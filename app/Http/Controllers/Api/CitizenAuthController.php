<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CitizenAuthController extends Controller
{
    /**
     * 📱 Register a new citizen
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'citizen',
            'is_online'  => true,
            'last_seen'  => now(),
        ]);

        $token = $user->createToken('mobile-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
                'profile_picture' => $user->profile_picture,
            ],
            'token' => $token,
        ], 201);
    }

    /**
     * 🔑 Login existing citizen
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
            ->where('role', 'citizen')
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->tokens()->delete();

        $token = $user->createToken('mobile-token')->plainTextToken;

        $user->update([
            'is_online' => true,
            'last_seen' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
                'profile_picture' => $user->profile_picture,
            ],
            'token' => $token,
        ]);
    }

    /**
     * 🔐 Google Mobile Login for Citizens
     */
    public function googleMobileLogin(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string',
        ]);

        try {
            /** @var \Laravel\Socialite\Contracts\User $googleUser */
            $googleUser = Socialite::driver('google')->userFromToken($request->access_token);

            $user = User::firstOrCreate(
                [
                    'email' => $googleUser->getEmail(),
                    'role' => 'citizen'
                ],
                [
                    'name' => $googleUser->getName(),
                    'password' => Hash::make(Str::random(16)),
                    'profile_picture' => $googleUser->getAvatar(),
                    'is_online' => true,
                    'last_seen' => now(),
                    'google_id' => $googleUser->getId(),
                ]
            );

            if (empty($user->google_id)) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'profile_picture' => $googleUser->getAvatar() ?? $user->profile_picture,
                ]);
            }

            $user->tokens()->delete();

            $token = $user->createToken('mobile-token')->plainTextToken;

            $user->update([
                'is_online' => true,
                'last_seen' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Google login successful!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'profile_picture' => $user->profile_picture,
                ],
                'token' => $token,
            ]);

        } catch (\Exception $e) {
            Log::error('Google Mobile Login Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Google login failed: ' . $e->getMessage(),
            ], 401);
        }
    }

    /**
     * 🚪 Logout (invalidate Sanctum token)
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();

            $user->update([
                'is_online' => false,
                'last_seen' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ]);
    }

    /**
     * 👤 Get the authenticated user's profile
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'profile_picture' => $user->profile_picture,
                'is_online' => $user->is_online,
                'last_seen' => $user->last_seen,
            ],
        ]);
    }

    /**
     * ✏️ Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
        ]);

        try {
            $user->update($request->only(['name', 'email']));

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'profile_picture' => $user->profile_picture,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile.',
            ], 500);
        }
    }

    /**
     * 📸 Upload profile picture
     */
    public function uploadProfilePicture(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            // Delete old profile picture if exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            
            $user->update(['profile_picture' => $path]);

            return response()->json([
                'success' => true,
                'message' => 'Profile picture uploaded successfully!',
                'profile_picture' => Storage::url($path),
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'profile_picture' => $user->profile_picture,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Profile picture upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload profile picture.',
            ], 500);
        }
    }

    /**
     * 🗑️ Remove profile picture
     */
    public function removeProfilePicture(Request $request)
    {
        $user = $request->user();

        try {
            // Delete file from storage
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $user->update(['profile_picture' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Profile picture removed successfully!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'profile_picture' => null,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Profile picture removal error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove profile picture.',
            ], 500);
        }
    }
}