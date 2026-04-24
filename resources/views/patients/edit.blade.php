@extends('layouts.app')

@section('title', 'Edit Patient')

@section('content')
<div class="page-title">
    <h3>Edit Patient</h3>
    <p>Update patient information.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')
        @include('patients._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary"><i class="fa-solid fa-pen-to-square me-2"></i>Update Patient</button>
            <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection