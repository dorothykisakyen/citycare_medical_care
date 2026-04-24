@extends('layouts.app')

@section('title', 'Edit Consultation Note')

@section('content')
<div class="page-title">
    <h3>Edit Consultation Note</h3>
    <p>Update the consultation record.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('consultation_notes.update', $consultation_note) }}" method="POST">
        @csrf
        @method('PUT')

        @include('consultation_notes._form')

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Consultation Note</button>
            <a href="{{ route('consultation_notes.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection