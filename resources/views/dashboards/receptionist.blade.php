@extends('layouts.app')

@section('title', 'Receptionist Dashboard')

@section('content')
{{-- Page Header: Provides a high-level title and description of the receptionist's primary duties --}}
<div class="page-title mb-4">
    <h3><i class="fa-solid fa-headset me-2 text-primary"></i>Receptionist Dashboard</h3>
    <p>Book, update, and cancel patient appointments.</p>
</div>

{{-- Appointment Metrics Row: Quick-glance counters for today's bookings and various status counts --}}
<div class="row g-4 mb-4">
    {{-- Count of appointments scheduled for the current day --}}
    <div class="col-md-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1">
                <i class="fa-solid fa-calendar-day me-2 text-primary"></i>Today
            </p>
            <h3>{{ $todayAppointments ?? 0 }}</h3>
        </div>
    </div>
    {{-- Count of appointments currently awaiting confirmation or check-in --}}
    <div class="col-md-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1">
                <i class="fa-solid fa-clock me-2 text-warning"></i>Pending
            </p>
            <h3>{{ $pendingAppointments ?? 0 }}</h3>
        </div>
    </div>
    {{-- Count of successfully confirmed patient bookings --}}
    <div class="col-md-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1">
                <i class="fa-solid fa-circle-check me-2 text-success"></i>Confirmed
            </p>
            <h3>{{ $confirmedAppointments ?? 0 }}</h3>
        </div>
    </div>
    {{-- Count of appointments that were voided or cancelled --}}
    <div class="col-md-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1">
                <i class="fa-solid fa-ban me-2 text-danger"></i>Cancelled
            </p>
            <h3>{{ $cancelledAppointments ?? 0 }}</h3>
        </div>
    </div>
</div>

{{-- Quick Actions: Practical shortcuts for common scheduling tasks and filtered lists --}}
<div class="dashboard-panel mb-4">
    <h5 class="mb-3">
        <i class="fa-solid fa-bolt me-2 text-primary"></i>Appointment Actions
    </h5>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-calendar-plus me-2"></i>Book Appointment
        </a>
        <a href="{{ route('appointments.index') }}" class="btn btn-outline-primary">
            <i class="fa-solid fa-pen-to-square me-2"></i>Update Appointment
        </a>
        <a href="{{ route('appointments.index', ['status' => 'pending']) }}" class="btn btn-outline-warning">
            <i class="fa-solid fa-clock me-2"></i>Pending Appointments
        </a>
        <a href="{{ route('appointments.index', ['status' => 'cancelled']) }}" class="btn btn-outline-danger">
            <i class="fa-solid fa-ban me-2"></i>Cancelled Appointments
        </a>
    </div>
</div>

{{-- Recent Appointments Table: Detailed log of the latest bookings with workflow status and quick-edit tools --}}
<div class="dashboard-panel table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">
            <i class="fa-solid fa-calendar-days me-2 text-primary"></i>Recent Appointments
        </h5>
        <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-primary">
            <i class="fa-solid fa-eye me-1"></i>View All
        </a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentAppointments as $appointment)
                <tr>
                    {{-- Displays the full name of the patient --}}
                    <td>
                        {{ $appointment->patient->first_name ?? '' }} {{ $appointment->patient->last_name ?? '' }}
                    </td>
                    {{-- Displays the full name of the assigned doctor --}}
                    <td>
                        Dr. {{ $appointment->doctor->first_name ?? '' }} {{ $appointment->doctor->last_name ?? '' }}
                    </td>
                    {{-- The scheduled date for the medical visit --}}
                    <td>{{ $appointment->appointment_date }}</td>
                    {{-- Formatted Time: Strips seconds to show HH:MM format (e.g., 10:30 - 11:00) --}}
                    <td>
                        {{ substr($appointment->appointment_time, 0, 5) }}
                        @if(!empty($appointment->end_time)) - {{ substr($appointment->end_time, 0, 5) }} @endif
                    </td>
                    {{-- Dynamic Badge: Color logic based on the appointment's lifecycle state --}}
                    <td>
                        @php
                            $statusClass = match($appointment->status) {
                                'confirmed' => 'badge-soft-primary',
                                'completed' => 'badge-soft-success',
                                'cancelled' => 'badge-soft-danger',
                                default     => 'badge-soft-warning',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }} text-capitalize">
                            {{ $appointment->status }}
                        </span>
                    </td>
                    {{-- Direct link to modify or void the specific appointment record --}}
                    <td class="text-end">
                        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pen me-1"></i>Update / Cancel
                        </a>
                    </td>
                </tr>
                @empty
                {{-- Empty State: Displayed when no appointment data has been recorded yet --}}
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No appointments found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
