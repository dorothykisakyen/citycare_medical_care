@extends('layouts.auth')

@section('title', 'Register')

@section('content')
{{-- Auth Header: Main registration title and instruction subtext --}}
<div class="auth-title">
    <h4>Create Account</h4>
    <p>Register to access CityCare system</p>
</div>

{{-- Alert Messages: Displays success notifications or validation error lists --}}
@include('partials.alerts')

{{-- Registration Form: Submits new user data to the registration controller --}}
<form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- Name Input: Captures the user's full name --}}
    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    {{-- Email Input: Unique primary identifier for the system account --}}
    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>

    {{-- Contact Input: Optional phone number for communication/SMS alerts --}}
    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
    </div>

    {{-- Secure Password Input: Minimum requirements handled by Laravel backend --}}
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    {{-- Confirmation Input: Ensures password matches to prevent typing errors --}}
    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>

    {{-- Submit Button: Includes Font Awesome icon for account creation --}}
    <button type="submit" class="btn btn-auth">
        <i class="fa-solid fa-user-plus me-2"></i>Create Account
    </button>
</form>

{{-- Auth Footer: Redirect link for existing users --}}
<div class="auth-footer">
    Already have an account? <a href="{{ route('login') }}">Login</a>
</div>
@endsection
