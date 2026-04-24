@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Consultation Note Details</h3>
    <p>View consultation note, diagnosis, prescription, and follow-up information.</p>
</div>

<div class="dashboard-panel">
    <div class="row g-4">
        <div class="col-md-6"><label class="form-label fw-semibold">Patient</label><input class="form-control" value="{{ $consultation_note->patient->first_name }} {{ $consultation_note->patient->last_name }}" readonly></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Doctor</label><input class="form-control" value="{{ $consultation_note->doctor->first_name }} {{ $consultation_note->doctor->last_name }}" readonly></div>
        <div class="col-12"><label class="form-label fw-semibold">Symptoms</label><textarea class="form-control" rows="3" readonly>{{ $consultation_note->symptoms ?: 'N/A' }}</textarea></div>
        <div class="col-12"><label class="form-label fw-semibold">Diagnosis</label><textarea class="form-control" rows="3" readonly>{{ $consultation_note->diagnosis ?: 'N/A' }}</textarea></div>
        <div class="col-12"><label class="form-label fw-semibold">Prescription</label><textarea class="form-control" rows="3" readonly>{{ $consultation_note->prescription ?: 'N/A' }}</textarea></div>
        <div class="col-12"><label class="form-label fw-semibold">Treatment Notes</label><textarea class="form-control" rows="4" readonly>{{ $consultation_note->treatment_notes ?: 'N/A' }}</textarea></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Follow Up Date</label><input class="form-control" value="{{ $consultation_note->follow_up_date ? $consultation_note->follow_up_date->format('d M Y') : 'N/A' }}" readonly></div>
    </div>
</div>
@endsection