<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StaffController extends Controller
{
    /**
     * Display a listing of staff users.
     */
    public function index()
    {
        $staffs = User::where('role', 'staff')->orderBy('id', 'asc')->get();
        return view('admin.staff.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new staff.
     */
    public function create()
    {
        return view('admin.staff.create');
    }

    /**
     * Store a newly created staff user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $profilePicturePath = null;
        
        // Handle file upload
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture' => $profilePicturePath,
            'role' => 'staff',
            'last_seen' => now(),
        ]);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff created successfully!');
    }

    /**
     * Display a specific staff user.
     */
    public function show(User $staff)
    {
        return view('admin.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified staff user.
     */
    public function edit(User $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff user.
     */
    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$staff->id}",
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Handle profile picture update
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($staff->profile_picture && Storage::disk('public')->exists($staff->profile_picture)) {
                Storage::disk('public')->delete($staff->profile_picture);
            }
            
            $data['profile_picture'] = $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff updated successfully!');
    }

    /**
     * Remove the specified staff user (JSON response for AJAX).
     */
    public function destroy(User $staff)
    {
        try {
            // Delete profile picture if exists
            if ($staff->profile_picture && Storage::disk('public')->exists($staff->profile_picture)) {
                Storage::disk('public')->delete($staff->profile_picture);
            }

            $staff->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Staff deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete staff: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove profile picture only.
     */
    public function removeProfilePicture(User $staff)
    {
        try {
            if ($staff->profile_picture && Storage::disk('public')->exists($staff->profile_picture)) {
                Storage::disk('public')->delete($staff->profile_picture);
            }

            $staff->update(['profile_picture' => null]);

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
     * Fetch staff data for AJAX auto-refresh.
     */
    public function fetchStaff()
    {
        $staffs = User::where('role', 'staff')->get()->map(function ($staff) {
            return [
                'id' => $staff->id,
                'name' => $staff->name,
                'email' => $staff->email,
                'profile_picture' => $staff->profile_picture ? Storage::url($staff->profile_picture) : null,
                'status' => $staff->status ?? 'offline',
                'status_color' => $staff->status_color ?? 'secondary',
                'last_seen' => $staff->last_seen
                    ? Carbon::parse($staff->last_seen)->toDateTimeString()
                    : null,
            ];
        });

        return response()->json($staffs);
    }
}