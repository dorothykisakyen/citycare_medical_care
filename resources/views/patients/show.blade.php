@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Patient Details</h3>
    <p>View patient bio-data, appointment history, and payments.</p>
</div>

<div class="dashboard-panel">
    <div class="row g-4">
        <div class="col-md-4"><label class="form-label fw-semibold">Patient Number</label><input class="form-control" value="{{ $patient->patient_number }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Full Name</label><input class="form-control" value="{{ $patient->first_name }} {{ $patient->last_name }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Gender</label><input class="form-control" value="{{ ucfirst($patient->gender) }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">DOB</label><input class="form-control" value="{{ $patient->date_of_birth->format('d M Y') }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Blood Group</label><input class="form-control" value="{{ $patient->blood_group ?: 'N/A' }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Phone</label><input class="form-control" value="{{ $patient->phone }}" readonly></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Email</label><input class="form-control" value="{{ $patient->email ?: 'N/A' }}" readonly></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Status</label><input class="form-control" value="{{ $patient->status ? 'Active' : 'Inactive' }}" readonly></div>
        <div class="col-12"><label class="form-label fw-semibold">Address</label><textarea class="form-control" rows="3" readonly>{{ $patient->address ?: 'N/A' }}</textarea></div>
    </div>
</div>
@endsection