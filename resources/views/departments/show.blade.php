@extends('layouts.app')

@section('title', 'Show Department')

@section('content')
<div class="page-title">
    <h3>Department Details</h3>
    <p>View the selected department information.</p>
</div>

<div class="dashboard-panel">
    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label fw-semibold">Name</label>
            <input type="text" class="form-control" value="{{ $department->name }}" readonly>
        </div>
        <div class="col-md-6">
            <label class="form-label fw-semibold">Status</label>
            <input type="text" class="form-control" value="{{ $department->status ? 'Active' : 'Inactive' }}" readonly>
        </div>
        <div class="col-12">
            <label class="form-label fw-semibold">Description</label>
            <textarea class="form-control" rows="4" readonly>{{ $department->description ?: 'N/A' }}</textarea>
        </div>
        <div class="col-12 d-flex gap-2">
            <a href="{{ route('departments.edit', $department) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </div>
</div>
@endsection