<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Incident;

class NotificationController extends Controller
{
    /**
     * Return the latest unread notifications (for dropdown)
     * Merges with latest incidents and ensures safe coordinates
     */
    public function latest(Request $request)
    {
        $user = $request->user();

        // 🔹 User's unread notifications
        $notifications = $user
            ? $user->unreadNotifications()
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($notif) {
                    return [
                        'id'         => $notif->id,
                        'title'      => $notif->data['title'] ?? 'Fire Incident Report',
                        'description' => $notif->data['description'] ?? 'No description available',
                        'location'   => $notif->data['location'] ?? 'Unknown Location',
                        'priority'   => $notif->data['priority'] ?? 'medium',
                        'latitude'   => $notif->data['latitude'] ?? null,
                        'longitude'  => $notif->data['longitude'] ?? null,
                        'created_at' => $notif->created_at->toDateTimeString(),
                    ];
                })
            : collect();

        // 🔹 Latest public incidents (take top 5)
        $latestIncidents = Incident::with('mapping')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($incident) {
                return [
                    'id'        => $incident->id,
                    'title'     => $incident->title,
                    'description' => $incident->description ?? 'No description available',
                    'location'  => $incident->location,
                    'priority'  => $incident->priority ?? 'medium',
                    'latitude'  => $incident->mapping->latitude ?? null,
                    'longitude' => $incident->mapping->longitude ?? null,
                    'created_at'=> $incident->created_at->toDateTimeString(),
                ];
            });

        // 🔹 Merge notifications and incidents
        $allNotifications = $notifications->merge($latestIncidents);

        return response()->json($allNotifications);
    }

    /**
     * Mark all unread notifications as read
     */
    public function markRead(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return response()->json(['status' => 'success']);
    }
}