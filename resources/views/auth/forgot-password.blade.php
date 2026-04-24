@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
{{-- Auth Header: Displays the main title and instructions for the user --}}
<div class="auth-title">
    <h4>Forgot Password</h4>
    <p>Enter your email to receive a reset code.</p>
</div>

{{-- Alerts: Includes session feedback for success (link sent) or error messages --}}
@include('partials.alerts')

{{-- Password Reset Request Form --}}
<form method="POST" action="{{ route('password.email') }}">
    @csrf

    {{-- Email Input: Required field to identify the user account --}}
    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" required autofocus>
    </div>

    {{-- Action Button: Triggers the backend logic to generate and send the reset token --}}
    <button type="submit" class="btn btn-auth">
        <i class="fa-solid fa-paper-plane me-2"></i>Send Reset Code
    </button>
</form>

{{-- Auth Footer: Navigation link to return to the primary login screen --}}
<div class="auth-footer">
    <a href="{{ route('login') }}">Back to Login</a>
</div>
@endsection
