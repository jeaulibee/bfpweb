<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // Step 1: Show the "Forgot Password" form
    public function showForgotForm()
    {
        return view('admin.auth.forgot-password'); // ✅ fixed path
    }

    // Step 2: Send OTP to email
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'No account found with that email.');
        }

        $otp = rand(100000, 999999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'created_at' => Carbon::now()
            ]
        );

        // ✅ Send email
        Mail::raw("Your Smart Fire Detection OTP code is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Smart Fire Detection OTP');
        });

        session(['reset_email' => $request->email]);

        return redirect()->route('otp.verify.form')->with('success', 'OTP sent to your email.');
    }

    // Step 3: Show the OTP verification form
    public function showVerifyOtpForm()
    {
        $email = session('reset_email');
        if (!$email) return redirect()->route('forgot.password.form');

        return view('admin.auth.verify-otp', compact('email')); // ✅ fixed path
    }

    // Step 4: Verify the OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $record = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$record) {
            return back()->with('error', 'No OTP found. Please request again.');
        }

        // Optional: Check if OTP expired (valid for 10 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            return back()->with('error', 'OTP expired. Please request a new one.');
        }

        if ($record->otp != $request->otp) {
            return back()->with('error', 'Invalid OTP.');
        }

        session(['reset_email' => $request->email]);
        return redirect()->route('reset.password.form')->with('success', 'OTP verified. You can now reset your password.');
    }

    // Step 5: Show reset password form
    public function showResetForm()
    {
        $email = session('reset_email');
        if (!$email) return redirect()->route('forgot.password.form');

        return view('admin.auth.reset-password', compact('email')); // ✅ fixed path
    }

    // Step 6: Save new password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        session()->forget('reset_email');

        return redirect('/admin/login')->with('success', 'Password reset successful! Please log in.');
    }
}
