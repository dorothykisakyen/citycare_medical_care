@extends('layouts.app')

@section('title', 'Create Department')

@section('content')
<div class="page-title">
    <h3>Create Department</h3>
    <p>Add a new medical department to the clinic system.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Department Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Create Department</h3>
    <p>Add a new medical department to the clinic system.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Department Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Save Department
                </button>
                <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </form>
</div>
@endsection

            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Save Department
                </button>
                <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </form>
</div>
@endsection