<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        $canRegister = User::count() === 0;
        return view('auth.login', compact('canRegister'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return $this->redirectByRole(Auth::user()->role);
        }

        return back()->withInput()->with('error', 'Invalid login credentials.');
    }

    public function showRegister()
    {
        if (User::count() === 0) {
            return view('auth.register', ['isFirstUser' => true]);
        }

        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Only admin can register users.');
        }

        return view('auth.register', ['isFirstUser' => false]);
    }

    public function register(Request $request)
    {
        $isFirstUser = User::count() === 0;

        if ($isFirstUser) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'nullable|string|max:20',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => 'admin',
                'is_active' => '1',
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);

            return $this->redirectByRole($user->role);
        }

        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Only admin can register users.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,receptionist,doctor,cashier,patient',
            'is_active' => 'required|boolean',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'is_active' => $request->is_active,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    protected function redirectByRole($role)
    {
        return match ($role) {
            'admin' => redirect()->route('dashboard.admin'),
            'receptionist' => redirect()->route('dashboard.receptionist'),
            'doctor' => redirect()->route('dashboard.doctor'),
            'cashier' => redirect()->route('dashboard.cashier'),
            'patient' => redirect()->route('dashboard.patient'),
            default => redirect()->route('login'),
        };
    }

    public function showForgotPassword()
{
    return view('auth.forgot-password');
}

public function sendResetCode(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $code = random_int(100000, 999999);

    session([
        'reset_email' => $request->email,
        'reset_code' => $code,
        'reset_code_expires_at' => now()->addMinutes(10),
    ]);

    Mail::raw("Your CityCare password reset code is: {$code}. This code expires in 10 minutes.", function ($message) use ($request) {
        $message->to($request->email)
            ->subject('CityCare Password Reset Code');
    });

    return redirect()->route('password.reset')
        ->with('success', 'A reset code has been sent to your email.');
}

public function showResetPassword()
{
    return view('auth.reset-password');
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'code' => 'required',
        'password' => 'required|min:6|confirmed',
    ]);

    if (
        !session('reset_code') ||
        !session('reset_email') ||
        session('reset_email') !== $request->email
    ) {
        return back()->with('error', 'Invalid reset request. Please request a new code.');
    }

    if (now()->greaterThan(session('reset_code_expires_at'))) {
        return redirect()->route('password.request')
            ->with('error', 'Reset code expired. Please request a new one.');
    }

    if ((string) session('reset_code') !== (string) $request->code) {
        return back()->with('error', 'Invalid reset code.');
    }

    $user = User::where('email', $request->email)->first();
    $user->password = Hash::make($request->password);
    $user->save();

    session()->forget([
        'reset_email',
        'reset_code',
        'reset_code_expires_at',
    ]);

    return redirect()->route('login')
        ->with('success', 'Password reset successfully. You can now login.');
}
}