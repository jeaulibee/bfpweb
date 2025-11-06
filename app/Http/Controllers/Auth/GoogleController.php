<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Staff login
    public function redirectToGoogleStaff()
    {
        session(['google_role' => 'staff', 'redirect_after_google' => route('staff.dashboard')]);
        return Socialite::driver('google')->redirect();
    }

    // Admin login
    public function redirectToGoogleAdmin()
    {
        session(['google_role' => 'admin', 'redirect_after_google' => route('admin.dashboard')]);
        return Socialite::driver('google')->redirect();
    }

    // Common callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $role = session('google_role', 'staff');
            $redirectUrl = session('redirect_after_google', route('landing'));

            if (!in_array($role, ['admin', 'staff'])) {
                return redirect('/')->with('error', 'Invalid login source.');
            }

            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                if ($existingUser->role !== $role) {
                    return redirect('/login')->with('error', 'Unauthorized access for this role.');
                }

                Auth::login($existingUser);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(uniqid()),
                    'avatar' => $googleUser->getAvatar(),
                    'role' => $role,
                    'email_verified_at' => now(),
                    'last_seen' => now(),
                    'is_online' => true
                ]);

                Auth::login($user);
            }

            session()->forget(['google_role', 'redirect_after_google']);

            return redirect($redirectUrl)->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Google login failed. Please try again.');
        }
    }
}
