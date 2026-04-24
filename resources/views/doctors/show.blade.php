@extends('layouts.app')

@section('title', 'Doctor Details')

@section('content')
<div class="page-title mb-4">
    <h3>Doctor Details</h3>
    <p>View doctor profile information.</p>
</div>

<div class="dashboard-panel">
    <div class="row g-3">
        <div class="col-md-4">
            <strong>Name</strong>
            <p>Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</p>
        </div>

        <div class="col-md-4">
            <strong>Department</strong>
            <p>{{ $doctor->department->name ?? 'N/A' }}</p>
        </div>

        <div class="col-md-4">
            <strong>Specialization</strong>
            <p>{{ $doctor->specialization ?? 'N/A' }}</p>
        </div>

        <div class="col-md-4">
            <strong>Gender</strong>
            <p>{{ ucfirst($doctor->gender ?? 'N/A') }}</p>
        </div>

        <div class="col-md-4">
            <strong>Phone</strong>
            <p>{{ $doctor->phone ?? 'N/A' }}</p>
        </div>

        <div class="col-md-4">
            <strong>Email</strong>
            <p>{{ $doctor->email ?? 'N/A' }}</p>
        </div>

        <div class="col-md-4">
            <strong>Consultation Fee</strong>
            <p>UGX {{ number_format($doctor->consultation_fee ?? 0) }}</p>
        </div>

        <div class="col-md-4">
            <strong>Status</strong>
            <p>{{ $doctor->status ? 'Active' : 'Inactive' }}</p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('doctors.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>
@endsection