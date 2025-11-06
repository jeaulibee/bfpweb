<?php

namespace App\Events;

use App\Models\Incident;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // CHANGED

class IncidentUpdated implements ShouldBroadcastNow // CHANGED
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $incident;
    public $isDeleted;

    /**
     * Create a new event instance.
     *
     * @param  mixed  $incident
     * @param  bool  $isDeleted
     */
    public function __construct($incident, $isDeleted = false)
    {
        $this->isDeleted = $isDeleted;

        if ($isDeleted) {
            $this->incident = ['id' => $incident];
        } else {
            $this->incident = [
                'id' => $incident->id,
                'title' => $incident->title,
                'description' => $incident->description,
                'location' => $incident->location ?? 'Unknown Location',
                'status' => $incident->status,
                'priority' => $incident->priority,
                'type' => $incident->type,
                'reporter_name' => $incident->reporter_name,
                'reported_by' => $incident->reported_by,
                'created_at' => $incident->created_at->toDateTimeString(),
                'created_at_human' => $incident->created_at->diffForHumans(),
                'coordinates' => $incident->coordinates,
                'latitude' => $incident->mapping->latitude ?? null,
                'longitude' => $incident->mapping->longitude ?? null,
                'priority_color' => $incident->priority_color,
                'type_icon' => $incident->type_icon,
                'has_coordinates' => $incident->hasCoordinates(),
                'action' => 'updated'
            ];
        }
    }

    /**
     * The name of the event to broadcast.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'incident.updated';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('incidents');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        if ($this->isDeleted) {
            return [
                'incident' => $this->incident,
                'action' => 'deleted',
                'message' => 'Incident has been deleted',
                'timestamp' => now()->toDateTimeString()
            ];
        }

        return [
            'incident' => $this->incident,
            'message' => 'Incident updated: ' . $this->incident['title'],
            'timestamp' => now()->toDateTimeString()
        ];
    }
}