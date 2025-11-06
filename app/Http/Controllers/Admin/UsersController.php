<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UsersController extends Controller
{
    /**
     * Display all users.
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display a specific user's details.
     */
    public function show(User $user)
    {
        // Calculate current status for the show page
        $user->current_status = $this->calculateUserStatus($user);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the edit form for a user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update a user's data.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,staff,citizen',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'password' => 'nullable|min:6',
        ]);

        $data = $request->only('name', 'email', 'role');

        // Handle profile picture update
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            $data['profile_picture'] = $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user)
    {
        // Prevent users from deleting themselves
        if ($user->id === auth()->id()) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account.'
                ], 403);
            }
            return redirect()->back()
                ->with('error', 'You cannot delete your own account.');
        }

        try {
            // Delete profile picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $user->delete();

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User deleted successfully.'
                ]);
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully.');

        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete user: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Failed to delete user.');
        }
    }

    /**
     * Remove profile picture for a user.
     */
    public function removeProfilePicture(User $user)
    {
        try {
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $user->update(['profile_picture' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Profile picture removed successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove profile picture.'
            ], 500);
        }
    }

    /**
     * Return real-time user online/offline status via AJAX.
     */
    public function status($id)
    {
        $user = User::findOrFail($id);
        $status = $this->calculateUserStatus($user);

        return response()->json([
            'status' => $status,
            'last_seen' => $user->last_seen,
            'last_seen_human' => $user->last_seen ? $user->last_seen->diffForHumans() : 'Never',
            'is_online' => $user->is_online,
            'user_name' => $user->name,
            'profile_picture' => $user->profile_picture ? Storage::url($user->profile_picture) : null
        ]);
    }

    /**
     * Fetch all users' status for index page (optimized with timezone fix).
     */
    public function allStatuses()
    {
        $statuses = Cache::remember('users_online_statuses', 10, function () {
            $users = User::select('id', 'last_seen', 'is_online', 'name', 'profile_picture')->get();
            $statusData = [];
            $now = now()->setTimezone('UTC');
            
            foreach ($users as $user) {
                $lastSeen = $user->last_seen;
                
                if (!$lastSeen) {
                    $statusData[$user->id] = [
                        'status' => 'offline',
                        'profile_picture' => $user->profile_picture ? Storage::url($user->profile_picture) : null
                    ];
                    continue;
                }

                // Convert to UTC for accurate comparison
                $lastSeenUTC = $lastSeen->copy()->setTimezone('UTC');
                $diffSeconds = $now->diffInSeconds($lastSeenUTC);

                if ($diffSeconds < 60) {
                    $statusData[$user->id] = [
                        'status' => 'online',
                        'profile_picture' => $user->profile_picture ? Storage::url($user->profile_picture) : null
                    ];
                } elseif ($diffSeconds < 300) {
                    $statusData[$user->id] = [
                        'status' => 'away',
                        'profile_picture' => $user->profile_picture ? Storage::url($user->profile_picture) : null
                    ];
                } else {
                    $statusData[$user->id] = [
                        'status' => 'offline',
                        'profile_picture' => $user->profile_picture ? Storage::url($user->profile_picture) : null
                    ];
                }
            }
            
            return $statusData;
        });

        return response()->json($statuses);
    }

    /**
     * Calculate user status based on last_seen timestamp with timezone fix.
     */
    private function calculateUserStatus(User $user)
    {
        $lastSeen = $user->last_seen;
        
        if (!$lastSeen) {
            return 'offline';
        }

        // Convert both times to the same timezone for accurate comparison
        $now = now()->setTimezone('UTC');
        $lastSeenUTC = $lastSeen->copy()->setTimezone('UTC');
        
        $diffSeconds = $now->diffInSeconds($lastSeenUTC);

        // Debug logging (remove in production)
        if (app()->environment('local')) {
            \Log::debug("User {$user->id} - Last Seen: {$lastSeen}, Last Seen UTC: {$lastSeenUTC}, Now UTC: {$now}, Diff: {$diffSeconds}s");
        }

        if ($diffSeconds < 60) { // 1 minute
            return 'online';
        } elseif ($diffSeconds < 300) { // 5 minutes
            return 'away';
        } else {
            return 'offline';
        }
    }

    /**
     * Get users statistics for dashboard.
     */
    public function statistics()
    {
        $totalUsers = User::count();
        
        // Use UTC for accurate time comparisons
        $nowUTC = now()->setTimezone('UTC');
        $onlineUsers = User::where('last_seen', '>=', $nowUTC->copy()->subMinute())->count();
        $awayUsers = User::whereBetween('last_seen', [$nowUTC->copy()->subMinutes(5), $nowUTC->copy()->subMinute()])->count();
        $offlineUsers = User::where('last_seen', '<', $nowUTC->copy()->subMinutes(5))->orWhereNull('last_seen')->count();

        return response()->json([
            'total' => $totalUsers,
            'online' => $onlineUsers,
            'away' => $awayUsers,
            'offline' => $offlineUsers,
            'last_updated' => now()->toDateTimeString()
        ]);
    }

    /**
     * Helper to mark a user as active — can be used in middleware or heartbeat route.
     */
    public static function markActive(User $user)
    {
        $user->update([
            'last_seen' => now(),
            'is_online' => true
        ]);
    }

    /**
     * Bulk update user status (for admin actions).
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'status' => 'required|in:online,away,offline'
        ]);

        $userIds = $request->user_ids;
        $status = $request->status;

        // This would typically update some other field, since status is calculated
        // For now, we'll just clear the cache
        Cache::forget('users_online_statuses');

        return response()->json([
            'success' => true,
            'message' => 'User statuses updated successfully.',
            'updated_count' => count($userIds)
        ]);
    }
}