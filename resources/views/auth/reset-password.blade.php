@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
{{-- Auth Header: Instructions for the user to complete the recovery process --}}
<div class="auth-title">
    <h4>Reset Password</h4>
    <p>Enter the code sent to your email.</p>
</div>

{{-- Alerts Section: Displays validation errors or session status updates --}}
@include('partials.alerts')

{{-- Password Update Form: Submits the security code and new credentials --}}
<form method="POST" action="{{ route('password.update') }}">
    @csrf

    {{-- Email Input: Pre-filled from session or old input for user convenience --}}
    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', session('reset_email')) }}" required>
    </div>

    {{-- Reset Code: The unique token sent to the user via email --}}
    <div class="mb-3">
        <label class="form-label">Reset Code</label>
        <input type="text" name="code" class="form-control" required>
    </div>

    {{-- New Password: The user's updated secure password --}}
    <div class="mb-3">
        <label class="form-label">New Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    {{-- Confirmation Field: Ensures the new password was typed correctly --}}
    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    {{-- Action Button: Finalizes the password reset process --}}
    <button type="submit" class="btn btn-auth">
        <i class="fa-solid fa-key me-2"></i>Reset Password
    </button>
</form>
@endsection
