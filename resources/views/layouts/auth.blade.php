<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Dynamic page title with a default fallback --}}
    <title>@yield('title', 'CityCare Auth')</title>
    
    {{-- External Styles: Bootstrap for layout, FontAwesome for icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    {{-- Custom Authentication Styles --}}
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-page">
        {{-- Left Section: Branding and marketing/informational content --}}
        <div class="auth-left">
            <div class="brand-box">
                <div class="brand-icon">
                    <i class="fa-solid fa-hospital"></i>
                </div>
                <h1>CityCare Medical Centre</h1>
                <p>Smart Healthcare Management System</p>
            </div>
            
            <div class="auth-info">
                <h3>Manage healthcare with confidence.</h3>
                <p>Secure access for admins, doctors, receptionists, cashiers, and patients.</p>
            </div>
        </div>

        {{-- Right Section: The functional area where Login/Register forms are injected --}}
        <div class="auth-right">
            <div class="auth-card">
                {{-- Yielding the specific form content (Login, Register, Forgot Password, etc.) --}}
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
