@extends('layouts.app')

@section('title', 'Create Consultation Note')

@section('content')
<div class="page-title">
    <h3>Create Consultation Note</h3>
    <p>Record a patient consultation from an existing appointment.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('consultation_notes.store') }}" method="POST">
        @csrf

        @include('consultation_notes._form')

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save Consultation Note</button>
            <a href="{{ route('consultation_notes.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection