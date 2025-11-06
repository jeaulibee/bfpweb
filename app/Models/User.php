<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'role',
        'last_seen',
        'is_online',
        'total_online_seconds',
    ];

    /**
     * Hidden fields
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_seen'         => 'datetime',
        'is_online'         => 'boolean',
        'total_online_seconds' => 'integer',
    ];

    // ======================
    // ROLE HELPERS
    // ======================
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isStaff(): bool { return $this->role === 'staff'; }
    public function isCitizen(): bool { return $this->role === 'citizen'; }

    // ======================
    // ONLINE STATUS HELPERS
    // ======================
    public function getStatusAttribute(): string
    {
        if (!$this->last_seen) return 'offline';

        $diffInSeconds = Carbon::now()->diffInSeconds($this->last_seen);

        if ($diffInSeconds <= 60) return 'active';   // Active if last seen within 1 minute
        return 'offline';                             // Offline if more than 1 minute
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'active' => 'green',
            default  => 'gray',
        };
    }

    public function lastSeenStatus(): string
    {
        return match ($this->status) {
            'active' => 'Active now',
            default  => 'Last seen ' . optional($this->last_seen)->diffForHumans() ?? 'Offline',
        };
    }
}
