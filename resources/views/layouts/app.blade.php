<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'CityCare Medical Centre')</title>

    {{-- Fonts & Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- App CSS --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    @stack('styles')
</head>

<body>

<div class="app-shell">

    {{-- SIDEBAR --}}
    @auth
        @include('partials.sidebar')
    @endauth

    {{-- MAIN AREA --}}
    <div class="main-area">

        {{-- TOPBAR --}}
        @auth
            @include('partials.navbar')
        @endauth

        {{-- CONTENT --}}
        <main class="main-content">
            @include('partials.alerts')
            @yield('content')
        </main>

        {{-- FOOTER --}}
        @include('partials.footer')

    </div>

</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

@stack('scripts')

</body>
</html>