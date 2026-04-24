@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')
{{-- Page Header: Displays the current action (Edit) and a brief description --}}
<div class="page-title">
    <h3>Edit Department</h3>
    <p>Update department information.</p>
</div>

<div class="dashboard-panel">
    {{-- Department Update Form: Uses PUT method as per RESTful routing standards --}}
    <form action="{{ route('departments.update', $department) }}" method="POST">
        @csrf
        @method('PUT') {{-- Method Spoofing: Necessary for Laravel to handle the update request --}}

        <div class="row g-3">
            {{-- Name Field: Populated with current department name, allows for old input on validation failure --}}
            <div class="col-md-6">
                <label class="form-label">Department Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $department->name) }}" required>
            </div>

            {{-- Status Selection: Toggle availability of the department within the clinic system --}}
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="1" {{ old('status', $department->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $department->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Description: Editable area for department-specific details or scope of service --}}
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $department->description) }}</textarea>
            </div>

            {{-- Action Buttons: Update trigger with Font Awesome icon and return navigation --}}
            <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary">
                    <i class="fa-solid fa-pen-to-square me-2"></i>Update Department
                </button>
                <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </form>
</div>
@endsection
