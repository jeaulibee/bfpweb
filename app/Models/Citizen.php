<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ For Sanctum auth
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // ✅ Token-based authentication for citizens

class Citizen extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'password',
    ];

    /**
     * Attributes hidden from serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Automatically cast fields.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Full name accessor.
     */
    public function getNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * A citizen can have many incidents.
     */
    public function incidents()
    {
        return $this->hasMany(Incident::class, 'citizen_id');
    }
}
