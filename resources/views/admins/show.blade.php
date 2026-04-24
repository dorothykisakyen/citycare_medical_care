@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Admin Details</h3>
    <p>View administrator profile details.</p>
</div>

<div class="dashboard-panel">
    <div class="row g-4">
        <div class="col-md-4"><label class="form-label fw-semibold">Admin Number</label><input class="form-control" value="{{ $admin->admin_number }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Full Name</label><input class="form-control" value="{{ $admin->first_name }} {{ $admin->last_name }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Gender</label><input class="form-control" value="{{ ucfirst($admin->gender ?? 'n/a') }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Phone</label><input class="form-control" value="{{ $admin->phone }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Email</label><input class="form-control" value="{{ $admin->email }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Job Title</label><input class="form-control" value="{{ $admin->job_title }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Hire Date</label><input class="form-control" value="{{ $admin->hire_date ? $admin->hire_date->format('d M Y') : 'N/A' }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Status</label><input class="form-control" value="{{ $admin->status ? 'Active' : 'Inactive' }}" readonly></div>
        <div class="col-12"><label class="form-label fw-semibold">Address</label><textarea class="form-control" rows="3" readonly>{{ $admin->address ?: 'N/A' }}</textarea></div>
    </div>
</div>
@endsection