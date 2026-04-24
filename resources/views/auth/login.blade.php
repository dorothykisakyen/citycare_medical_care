@extends('layouts.auth')

@section('title', 'Login')

@section('content')
{{-- Auth Header: Displays a welcoming title and the facility name --}}
<div class="auth-title">
    <h4>Welcome Back</h4>
    <p>Login to CityCare Medical Centre</p>
</div>

{{-- Alerts Section: Displays validation errors or session flash messages --}}
@include('partials.alerts')

{{-- Authentication Form: Sends credentials to the login route --}}
<form method="POST" action="{{ route('login') }}">
    @csrf

    {{-- Email Input: Standard email field with 'old' value retention --}}
    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
    </div>

    {{-- Password Input: Required field for secure authentication --}}
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    {{-- Login Button: Includes a Font Awesome icon for visual reinforcement --}}
    <button type="submit" class="btn btn-auth">
        <i class="fa-solid fa-right-to-bracket me-2"></i>Login
    </button>
</form>

{{-- Auth Footer: Navigation for users who have forgotten their account password --}}
<div class="auth-footer">
    <a href="{{ route('password.request') }}">Forgot Password</a>
</div>
@endsection
