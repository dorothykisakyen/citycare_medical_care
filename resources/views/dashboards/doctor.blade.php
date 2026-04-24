@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
{{-- Header: Provides a welcome title and summary of the doctor's access capabilities --}}
<div class="page-title mb-4">
    <h3><i class="fa-solid fa-user-doctor me-2 text-primary"></i>Doctor Dashboard</h3>
    <p>View appointments, patient information, consultation notes, and treatment records.</p>
</div>

{{-- Profile Check: Alert displayed if the authenticated user has not been linked to a specific Doctor record --}}
@if(!$doctor)
<div class="alert alert-warning">
    <i class="fa-solid fa-triangle-exclamation me-2"></i> Your account is not linked to a doctor profile yet.
</div>
@endif

{{-- Summary Statistics: High-level counts for the doctor's daily and overall workload --}}
<div class="row g-4 mb-4">
    {{-- Counts appointments scheduled for the current date --}}
    <div class="col-md-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1"><i class="fa-solid fa-calendar-day me-2 text-primary"></i>Today Appointments</p>
            <h3>{{ $todayAppointments ?? 0 }}</h3>
        </div>
    </div>
    {{-- Total lifetime appointments assigned to this doctor --}}
    <div class="col-md-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1"><i class="fa-solid fa-calendar-check me-2 text-success"></i>All Appointments</p>
            <h3>{{ $totalDoctorAppointments ?? 0 }}</h3>
        </div>
    </div>
    {{-- Total number of medical notes recorded by this doctor --}}
    <div class="col-md-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1"><i class="fa-solid fa-notes-medical me-2 text-warning"></i>Consultation Notes</p>
            <h3>{{ $totalConsultations ?? 0 }}</h3>
        </div>
    </div>
    {{-- Count of unique patients who have completed a consultation --}}
    <div class="col-md-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1"><i class="fa-solid fa-stethoscope me-2 text-info"></i>Treated Patients</p>
            <h3>{{ $treatedPatients ?? 0 }}</h3>
        </div>
    </div>
</div>

{{-- Appointments Table: Lists upcoming or recent patient bookings with contact details --}}
<div class="dashboard-panel table-card mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="fa-solid fa-calendar-days me-2 text-primary"></i>Appointments & Patient Information</h5>
        <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-primary">
            <i class="fa-solid fa-eye me-1"></i>View
        </a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th><i class="fa-solid fa-user me-1"></i>Patient</th>
                    <th><i class="fa-solid fa-phone me-1"></i>Phone</th>
                    <th><i class="fa-solid fa-venus-mars me-1"></i>Gender</th>
                    <th><i class="fa-solid fa-calendar me-1"></i>Date</th>
                    <th><i class="fa-solid fa-circle-info me-1"></i>Status</th>
                    <th><i class="fa-solid fa-gear me-1"></i>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->first_name ?? '' }} {{ $appointment->patient->last_name ?? '' }}</td>
                    <td>{{ $appointment->patient->phone ?? 'N/A' }}</td>
                    <td>{{ $appointment->patient->gender ?? 'N/A' }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>
                        {{-- Status Badge: Uses primary color and capitalizes the current workflow status --}}
                        <span class="badge bg-primary text-capitalize">{{ $appointment->status }}</span>
                    </td>
                    <td>
                        {{-- Quick Action: Link to modify appointment status or details --}}
                        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pen me-1"></i>Update
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No appointments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Clinical Records Table: Displays recent medical consultations, diagnoses, and prescriptions --}}
<div class="dashboard-panel table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="fa-solid fa-notes-medical me-2 text-success"></i>Consultation Notes & Treatment</h5>
        <a href="{{ route('consultation_notes.index') }}" class="btn btn-sm btn-outline-primary">
            <i class="fa-solid fa-eye me-1"></i>View
        </a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th><i class="fa-solid fa-user me-1"></i>Patient</th>
                    <th><i class="fa-solid fa-head-side-cough me-1"></i>Symptoms</th>
                    <th><i class="fa-solid fa-stethoscope me-1"></i>Diagnosis</th>
                    <th><i class="fa-solid fa-prescription-bottle-medical me-1"></i>Prescription</th>
                    <th><i class="fa-solid fa-clipboard-list me-1"></i>Treatment</th>
                    <th><i class="fa-solid fa-gear me-1"></i>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentConsultations as $note)
                <tr>
                    <td>{{ $note->patient->first_name ?? '' }} {{ $note->patient->last_name ?? '' }}</td>
                    <td>{{ $note->symptoms ?? 'N/A' }}</td>
                    <td>{{ $note->diagnosis ?? 'N/A' }}</td>
                    <td>{{ $note->prescription ?? 'N/A' }}</td>
                    <td>{{ $note->treatment_notes ?? 'N/A' }}</td>
                    <td>
                        {{-- Quick Action: Edit medical notes or prescriptions --}}
                        <a href="{{ route('consultation_notes.edit', $note) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pen me-1"></i>Update
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No consultation notes found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
