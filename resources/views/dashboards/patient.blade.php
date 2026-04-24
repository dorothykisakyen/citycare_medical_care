@extends('layouts.app')

@section('title', 'Patient Dashboard')

@section('content')
{{-- Page Header: Provides the patient with a clear overview of their medical and financial standing --}}
<div class="page-title mb-4">
    <h3><i class="fa-solid fa-user-injured me-2 text-primary"></i>Patient Dashboard</h3>
    <p>View your profile, upcoming appointments, visit history, and payment status.</p>
</div>

{{-- Profile Verification: Displays a warning if the logged-in user isn't linked to a Patient record --}}
@if(!$patient)
<div class="alert alert-warning">
    Your account is not linked to a patient profile yet. Please contact the clinic.
</div>
@endif

{{-- Summary Stats Row: Quick glance metrics for appointments, history, and billing --}}
<div class="row g-4 mb-4">
    {{-- Count of active/future bookings --}}
    <div class="col-md-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1"><i class="fa-solid fa-calendar-check me-2 text-primary"></i>Upcoming Appointments</p>
            <h3>{{ $upcomingAppointmentsCount ?? 0 }}</h3>
        </div>
    </div>
    {{-- Count of past clinical consultations --}}
    <div class="col-md-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1"><i class="fa-solid fa-notes-medical me-2 text-success"></i>Visit History</p>
            <h3>{{ $visitHistoryCount ?? 0 }}</h3>
        </div>
    </div>
    {{-- Total number of payment transactions --}}
    <div class="col-md-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1"><i class="fa-solid fa-receipt me-2 text-warning"></i>Total Payments</p>
            <h3>{{ $paymentCount ?? 0 }}</h3>
        </div>
    </div>
    {{-- Cumulative total of all payments made in UGX --}}
    <div class="col-md-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1"><i class="fa-solid fa-money-bill-wave me-2 text-info"></i>Amount Paid</p>
            <h3>UGX {{ number_format($totalPaid ?? 0, 2) }}</h3>
        </div>
    </div>
</div>

{{-- Personal Profile Section: Displays demographic and contact information from the database --}}
<div class="dashboard-panel mb-4">
    <h5 class="mb-3"><i class="fa-solid fa-id-card me-2 text-primary"></i>Personal Profile</h5>
    <div class="row g-3">
        <div class="col-md-4">
            <strong>Full Name</strong>
            <p>{{ $patient->first_name ?? '' }} {{ $patient->last_name ?? '' }}</p>
        </div>
        <div class="col-md-4">
            <strong>Phone</strong>
            <p>{{ $patient->phone ?? 'N/A' }}</p>
        </div>
        <div class="col-md-4">
            <strong>Email</strong>
            <p>{{ auth()->user()->email ?? 'N/A' }}</p>
        </div>
        <div class="col-md-4">
            <strong>Gender</strong>
            <p>{{ $patient->gender ?? 'N/A' }}</p>
        </div>
        <div class="col-md-4">
            <strong>Blood Group</strong>
            <p>{{ $patient->blood_group ?? 'N/A' }}</p>
        </div>
        <div class="col-md-4">
            <strong>Address</strong>
            <p>{{ $patient->address ?? 'N/A' }}</p>
        </div>
    </div>
</div>

{{-- Upcoming Appointments Table: Shows specific details of future visits --}}
<div class="dashboard-panel table-card mb-4">
    <h5 class="mb-3"><i class="fa-solid fa-calendar-days me-2 text-success"></i>Upcoming Appointments</h5>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Reason</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($upcomingAppointments as $appointment)
                <tr>
                    <td>Dr. {{ $appointment->doctor->first_name ?? '' }} {{ $appointment->doctor->last_name ?? '' }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    {{-- Time display: Formats start and end times to HH:MM format --}}
                    <td>
                        {{ substr($appointment->appointment_time, 0, 5) }}
                        @if(!empty($appointment->end_time)) - {{ substr($appointment->end_time, 0, 5) }} @endif
                    </td>
                    <td>{{ $appointment->reason ?? 'N/A' }}</td>
                    <td><span class="badge bg-primary text-capitalize">{{ $appointment->status }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No upcoming appointments.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Visit History Table: Displays clinical details from past consultations --}}
<div class="dashboard-panel table-card mb-4">
    <h5 class="mb-3"><i class="fa-solid fa-notes-medical me-2 text-primary"></i>Visit History</h5>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Symptoms</th>
                    <th>Diagnosis</th>
                    <th>Prescription</th>
                    <th>Treatment</th>
                    <th>Follow Up</th>
                </tr>
            </thead>
            <tbody>
                @forelse($visitHistory as $note)
                <tr>
                    <td>Dr. {{ $note->doctor->first_name ?? '' }} {{ $note->doctor->last_name ?? '' }}</td>
                    <td>{{ $note->symptoms ?? 'N/A' }}</td>
                    <td>{{ $note->diagnosis ?? 'N/A' }}</td>
                    <td>{{ $note->prescription ?? 'N/A' }}</td>
                    <td>{{ $note->treatment_notes ?? 'N/A' }}</td>
                    <td>{{ $note->follow_up_date ? $note->follow_up_date->format('d M Y') : 'N/A' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No visit history found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Payment Status Table: Tracks financial history related to appointments --}}
<div class="dashboard-panel table-card">
    <h5 class="mb-3"><i class="fa-solid fa-money-check-dollar me-2 text-success"></i>Payment Status</h5>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Appointment</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->appointment->appointment_number ?? 'N/A' }}</td>
                    <td>UGX {{ number_format($payment->amount ?? 0, 2) }}</td>
                    <td>{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                    {{-- Date logic: Uses explicit payment_date or falls back to record creation timestamp --}}
                    <td>{{ isset($payment->payment_date) ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : $payment->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="badge bg-success text-capitalize">
                            {{ $payment->status ?? 'paid' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No payment records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
