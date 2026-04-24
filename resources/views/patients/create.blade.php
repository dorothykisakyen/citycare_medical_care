@extends('layouts.app')

@section('title', 'Create Patient')

@section('content')
<div class="page-title">
    <h3>Create Patient</h3>
    <p>Add a new patient record.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('patients.store') }}" method="POST">
        @csrf
        @include('patients._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-2"></i>Save Patient</button>
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection