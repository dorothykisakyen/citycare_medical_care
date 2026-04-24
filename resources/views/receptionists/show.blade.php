@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Receptionist Details</h3>
    <p>View receptionist profile details.</p>
</div>

<div class="dashboard-panel">
    <div class="row g-4">
        <div class="col-md-4"><label class="form-label fw-semibold">Receptionist Number</label><input class="form-control" value="{{ $receptionist->receptionist_number }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Full Name</label><input class="form-control" value="{{ $receptionist->first_name }} {{ $receptionist->last_name }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Gender</label><input class="form-control" value="{{ ucfirst($receptionist->gender ?? 'n/a') }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Phone</label><input class="form-control" value="{{ $receptionist->phone }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Email</label><input class="form-control" value="{{ $receptionist->email }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Shift</label><input class="form-control" value="{{ $receptionist->shift ?: 'N/A' }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Hire Date</label><input class="form-control" value="{{ $receptionist->hire_date ? $receptionist->hire_date->format('d M Y') : 'N/A' }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Status</label><input class="form-control" value="{{ $receptionist->status ? 'Active' : 'Inactive' }}" readonly></div>
        <div class="col-12"><label class="form-label fw-semibold">Address</label><textarea class="form-control" rows="3" readonly>{{ $receptionist->address ?: 'N/A' }}</textarea></div>
    </div>
</div>
@endsection