@extends('layouts.app')

@section('content')
{{-- Page Header: Title and subtitle for the specific appointment view --}}
<div class="page-title">
    <h3>Appointment Details</h3>
    <p>View the full appointment information.</p>
</div>

<div class="dashboard-panel">
    <div class="row g-4">
        {{-- Patient Information: Combined first and last name --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Patient</label>
            <input class="form-control" value="{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}" readonly>
        </div>

        {{-- Assigned Medical Practitioner --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Doctor</label>
            <input class="form-control" value="{{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}" readonly>
        </div>

        {{-- Clinic Department / Specialty --}}
        <div class="col-md-4">
            <label class="form-label fw-semibold">Department</label>
            <input class="form-control" value="{{ $appointment->department->name }}" readonly>
        </div>

        {{-- Formatted Appointment Date --}}
        <div class="col-md-4">
            <label class="form-label fw-semibold">Date</label>
            <input class="form-control" value="{{ $appointment->appointment_date->format('d M Y') }}" readonly>
        </div>

        {{-- Time Range: Formatted to 24h HH:MM (e.g., 09:00 - 10:00) --}}
        <div class="col-md-4">
            <label class="form-label fw-semibold">Time</label>
            <input class="form-control" value="{{ substr($appointment->appointment_time,0,5) }} - {{ substr($appointment->end_time,0,5) }}" readonly>
        </div>

        {{-- Patient's stated reason for the visit --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Reason</label>
            <input class="form-control" value="{{ $appointment->reason }}" readonly>
        </div>

        {{-- Current Workflow Status: Capitalized for readability --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Status</label>
            <input class="form-control" value="{{ ucfirst($appointment->status) }}" readonly>
        </div>

        {{-- Additional Clinical or Administrative Notes --}}
        <div class="col-12">
            <label class="form-label fw-semibold">Notes</label>
            <textarea class="form-control" rows="3" readonly>{{ $appointment->notes ?: 'N/A' }}</textarea>
        </div>
    </div>
</div>
@endsection
