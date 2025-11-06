<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'location',
        'status',
        'reported_by', // staff user who reported
        'citizen_id',  // citizen who reported
        'assigned_to', // staff assignment
        'priority',    // NEW
        'type',        // NEW
    ];

    /**
     * Always eager load these relationships for performance.
     */
    protected $with = ['mapping', 'reporter', 'assignee', 'citizen'];

    /**
     * Mapping relation — each incident has one mapping (latitude/longitude).
     */
    public function mapping()
    {
        return $this->hasOne(Mapping::class, 'incident_id');
    }

    /**
     * Staff who reported this incident.
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    /**
     * Staff assigned to handle this incident.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Citizen who reported this incident.
     */
    public function citizen()
    {
        return $this->belongsTo(Citizen::class, 'citizen_id');
    }

    /**
     * Helper: Get coordinates as [lat, lng].
     */
    public function getCoordinatesAttribute(): array
    {
        return $this->mapping
            ? [$this->mapping->latitude, $this->mapping->longitude]
            : [null, null];
    }

    /**
     * Helper: Check if this incident has valid coordinates.
     */
    public function hasCoordinates(): bool
    {
        return $this->mapping
            && !is_null($this->mapping->latitude)
            && !is_null($this->mapping->longitude);
    }

    /**
     * Helper: Identify who reported the incident (citizen or staff).
     */
    public function getReporterNameAttribute(): ?string
    {
        if ($this->citizen) {
            return $this->citizen->name ?? 'Unknown Citizen';
        } elseif ($this->reporter) {
            return $this->reporter->name ?? 'Unknown Staff';
        }
        return null;
    }

    /**
     * NEW: Get priority with color coding
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'red',
            'critical' => 'purple',
            default => 'gray'
        };
    }

    /**
     * NEW: Get type with icon
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'safety' => '🚧',
            'security' => '🔒',
            'environmental' => '🌿',
            'equipment' => '🔧',
            'medical' => '🏥',
            'other' => '📋',
            default => '📄'
        };
    }
}