@php
    $role = auth()->user()->role;
@endphp

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div>
            <h4 class="logo-text mb-0">CityCare</h4>
            <small class="logo-subtitle">Medical Centre</small>
        </div>
        <button class="sidebar-close d-lg-none" id="sidebarClose" type="button">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <ul class="sidebar-menu">

        {{-- Dashboard --}}
        <li>
            <a href="{{ route('dashboard.' . $role) }}"
               class="sidebar-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- Admin: full system access --}}
        @if($role === 'admin')
            <li>
                <a href="{{ route('patients.index') }}" class="sidebar-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-injured"></i>
                    <span>Patients</span>
                </a>
            </li>

            <li>
                <a href="{{ route('doctors.index') }}" class="sidebar-link {{ request()->routeIs('doctors.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-doctor"></i>
                    <span>Doctors</span>
                </a>
            </li>

            <li>
                <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Users</span>
                </a>
            </li>

            <li>
                <a href="{{ route('departments.index') }}" class="sidebar-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-building-user"></i>
                    <span>Departments</span>
                </a>
            </li>

            <li>
                <a href="{{ route('schedules.index') }}" class="sidebar-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clock"></i>
                    <span>Schedules</span>
                </a>
            </li>

            <li>
                <a href="{{ route('appointments.index') }}" class="sidebar-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span>Appointments</span>
                </a>
            </li>

            <li>
                <a href="{{ route('consultation_notes.index') }}" class="sidebar-link {{ request()->routeIs('consultation_notes.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-notes-medical"></i>
                    <span>Consultation Notes</span>
                </a>
            </li>

            <li>
                <a href="{{ route('payments.index') }}" class="sidebar-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <span>Payments</span>
                </a>
            </li>

            <li>
                <a href="{{ route('reports.index') }}" class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Reports</span>
                </a>
            </li>

            <li>
                <a href="{{ route('activity_logs.index') }}" class="sidebar-link {{ request()->routeIs('activity_logs.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-list-check"></i>
                    <span>Activity Logs</span>
                </a>
            </li>
        @endif

        {{-- Doctor: appointments, schedule, patient info, consultation notes, treatment history --}}
        @if($role === 'doctor')
            <li>
                <a href="{{ route('appointments.index') }}" class="sidebar-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span>Appointments</span>
                </a>
            </li>

            <li>
                <a href="{{ route('patients.index') }}" class="sidebar-link {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-injured"></i>
                    <span>Patient Info</span>
                </a>
            </li>

            <li>
                <a href="{{ route('consultation_notes.index') }}" class="sidebar-link {{ request()->routeIs('consultation_notes.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-notes-medical"></i>
                    <span>Consultations</span>
                </a>
            </li>

            <li>
                <a href="{{ route('schedules.index') }}" class="sidebar-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clock"></i>
                    <span>Schedule</span>
                </a>
            </li>
        @endif

        {{-- Receptionist: appointments only --}}
        @if($role === 'receptionist')
            <li>
                <a href="{{ route('appointments.index') }}" class="sidebar-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span>Appointments</span>
                </a>
            </li>
        @endif

        {{-- Cashier: payments only --}}
        @if($role === 'cashier')
            <li>
                <a href="{{ route('payments.index') }}" class="sidebar-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <span>Payments</span>
                </a>
            </li>
        @endif

        {{-- Patient: own dashboard only --}} 
        @if($role === 'patient') 
        <li> <a href="{{ route('dashboard.patient') }}" 
        class="sidebar-link {{ request()->routeIs('dashboard.patient') ? 'active' : '' }}"> 
            <i class="fa-solid fa-user"></i> <span>My Profile</span> </a> 
        </li> 
        @endif

    </ul>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>