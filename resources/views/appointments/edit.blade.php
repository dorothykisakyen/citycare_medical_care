@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Edit Appointment</h3>
    <p>Update appointment details and time allocation.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('appointments.update', $appointment) }}" method="POST">
        @csrf
        @method('PUT')
        @include('appointments._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Update Appointment</button>
            <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection