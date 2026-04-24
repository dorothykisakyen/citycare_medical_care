@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Cashier Details</h3>
    <p>View cashier profile details.</p>
</div>

<div class="dashboard-panel">
    <div class="row g-4">
        <div class="col-md-4"><label class="form-label fw-semibold">Cashier Number</label><input class="form-control" value="{{ $cashier->cashier_number }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Full Name</label><input class="form-control" value="{{ $cashier->first_name }} {{ $cashier->last_name }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Gender</label><input class="form-control" value="{{ ucfirst($cashier->gender ?? 'n/a') }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Phone</label><input class="form-control" value="{{ $cashier->phone }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Email</label><input class="form-control" value="{{ $cashier->email }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Shift</label><input class="form-control" value="{{ $cashier->shift ?: 'N/A' }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Hire Date</label><input class="form-control" value="{{ $cashier->hire_date ? $cashier->hire_date->format('d M Y') : 'N/A' }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Status</label><input class="form-control" value="{{ $cashier->status ? 'Active' : 'Inactive' }}" readonly></div>
        <div class="col-12"><label class="form-label fw-semibold">Address</label><textarea class="form-control" rows="3" readonly>{{ $cashier->address ?: 'N/A' }}</textarea></div>
    </div>
</div>
@endsection