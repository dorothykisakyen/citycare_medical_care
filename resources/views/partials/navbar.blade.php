@php
    /**
     * Topbar Logic:
     * Extracts the authenticated user's details and generates 
     * a single-letter initial for the profile avatar.
     */
    $user = auth()->user();
    $initial = strtoupper(substr($user->name, 0, 1));
@endphp

<div class="topbar">
    <div class="d-flex justify-content-between align-items-center topbar-inner">
        
        {{-- Left Section: Mobile toggle and Greeting --}}
        <div class="d-flex align-items-center gap-3">
            {{-- Sidebar Toggle: visible only on small screens (tablets/phones) --}}
            <button class="btn btn-outline-primary d-lg-none" id="sidebarToggle" type="button">
                <i class="fa-solid fa-bars"></i>
            </button>
            
            {{-- Welcome Message: Displays user name, role, and the current system date --}}
            <div class="topbar-title">
                <h5>Welcome back, {{ $user->name }}</h5>
                <small>{{ ucfirst($user->role) }} Panel • {{ now()->format('l, d F Y') }}</small>
            </div>
        </div>

        {{-- Right Section: Global Search, User Profile, and Logout --}}
        <div class="topbar-right">
            
            {{-- Global Search: Form to search across various medical modules --}}
            <div class="search-box">
                <form action="{{ route('search.global') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        </span>
                        <input type="text" name="q" class="form-control" placeholder="Search patients, doctors, appointments..." value="{{ request('q') }}">
                    </div>
                </form>
            </div>

            {{-- User Identity Pill: Displays profile initial avatar, name, and role --}}
            <div class="user-pill">
                <div class="avatar">{{ $initial }}</div>
                <div>
                    <div class="fw-semibold">{{ $user->name }}</div>
                    <small class="text-muted">{{ ucfirst($user->role) }}</small>
                </div>
            </div>

            {{-- Logout Action: Secure POST request to terminate the user session --}}
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger topbar-logout-btn">
                    <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
</div>
