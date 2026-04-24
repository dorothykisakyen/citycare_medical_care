@extends('layouts.app')

@section('title', 'Create Doctor')

@section('content')
<div class="page-title mb-4">
    <h3>Create Doctor</h3>
    <p>Add a new doctor record.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('doctors.store') }}" method="POST">
            @csrf

            @include('doctors._form')

            <div class="mt-4 d-flex justify-content-end gap-2">
                <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-2"></i>Save Doctor</button>
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection