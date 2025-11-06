<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Alert;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'serial_number', 'location', 'status', 'last_active'];

    protected $attributes = [
        'status' => 'offline'
    ];

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    // Scope for online devices
    public function scopeOnline($query)
    {
        return $query->where('status', 'online');
    }

    // Scope for warning devices
    public function scopeWarning($query)
    {
        return $query->where('status', 'warning');
    }

    // Scope for offline devices
    public function scopeOffline($query)
    {
        return $query->where('status', 'offline');
    }

    // Update last active when status changes to online
    public function setStatusAttribute($value)
    {
        if ($value === 'online' && (!isset($this->attributes['status']) || $this->attributes['status'] !== 'online')) {
            $this->attributes['last_active'] = now();
        }
        $this->attributes['status'] = $value;
    }
}