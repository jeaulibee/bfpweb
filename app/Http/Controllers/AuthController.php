<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    // =========================
    // Show login forms
    // =========================
    public function showAdminLogin()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth', [
            'mode' => 'login',
            'role' => 'admin'
        ]);
    }

    public function showStaffLogin()
    {
        if (Auth::check() && Auth::user()->role === 'staff') {
            return redirect()->route('staff.dashboard');
        }

        return view('staff.auth', [
            'mode' => 'login',
            'role' => 'staff'
        ]);
    }

    public function showCitizenLogin()
    {
        if (Auth::check() && Auth::user()->role === 'citizen') {
            return redirect()->route('citizen.dashboard');
        }

        return view('citizen.auth', [
            'mode' => 'login',
            'role' => 'citizen'
        ]);
    }

    // =========================
    // Show registration forms
    // =========================
    public function showAdminRegister()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth', [
            'mode' => 'register',
            'role' => 'admin'
        ]);
    }

    public function showStaffRegister()
    {
        if (Auth::check() && Auth::user()->role === 'staff') {
            return redirect()->route('staff.dashboard');
        }

        return view('staff.auth', [
            'mode' => 'register',
            'role' => 'staff'
        ]);
    }

    public function showCitizenRegister()
    {
        if (Auth::check() && Auth::user()->role === 'citizen') {
            return redirect()->route('citizen.dashboard');
        }

        return view('citizen.auth', [
            'mode' => 'register',
            'role' => 'citizen'
        ]);
    }

    // =========================
    // Handle logins
    // =========================
    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            /** @var User $user */
            $user = Auth::user();

            if ($user->role === 'admin') {
                $user->update(['last_seen' => now(), 'is_online' => true]);
                return redirect()
                    ->route('admin.dashboard')
                    ->with('success', 'Welcome back, ' . $user->name . '!');
            }

            Auth::logout();
            return back()->with('error', 'Unauthorized access. Admins only.');
        }

        return back()->with('error', 'Invalid email or password.');
    }

    public function staffLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            /** @var User $user */
            $user = Auth::user();

            if ($user->role === 'staff') {
                $user->update(['last_seen' => now(), 'is_online' => true]);
                return redirect()
                    ->route('staff.dashboard')
                    ->with('success', 'Welcome back, ' . $user->name . '!');
            }

            Auth::logout();
            return back()->with('error', 'Unauthorized access. Staff only.');
        }

        return back()->with('error', 'Invalid email or password.');
    }

    public function citizenLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            /** @var User $user */
            $user = Auth::user();

            if ($user->role === 'citizen') {
                $user->update(['last_seen' => now(), 'is_online' => true]);

                return response()->json([
                    'success' => true,
                    'message' => 'Welcome back, ' . $user->name . '!',
                    'user' => $user
                ]);
            }

            Auth::logout();
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access. Citizens only.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password.'
        ]);
    }

    // =========================
    // Handle registration
    // =========================
    public function adminRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'last_seen' => now(),
            'is_online' => false
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'Registration successful! Please login.');
    }

    public function staffRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
            'last_seen' => now(),
            'is_online' => false
        ]);

        return redirect()->route('staff.login')
            ->with('success', 'Registration successful! Please login.');
    }

    public function citizenRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'citizen',
            'last_seen' => now(),
            'is_online' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Please login.',
            'user' => $user
        ]);
    }

    // =========================
    // Handle heartbeat for online status
    // =========================
    public function heartbeat(Request $request)
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            $user->update([
                'last_seen' => now(),
                'is_online' => true
            ]);

            return response()->json([
                'status' => 'updated',
                'last_seen' => now()->toDateTimeString(),
                'user_id' => $user->id
            ]);
        }

        return response()->json([
            'status' => 'not_authenticated'
        ], 401);
    }

    // =========================
    // Handle logout
    // =========================
    public function logout()
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            $user->update([
                'last_seen' => now(),
                'is_online' => false
            ]);
        }

        Auth::logout();

        return redirect()->route('landing')
            ->with('success', 'You have been logged out.');
    }

    // =========================
    // Handle OTP resend
    // =========================
    public function resendOtp(Request $request)
    {
        // Your existing OTP resend logic here
    }
}
