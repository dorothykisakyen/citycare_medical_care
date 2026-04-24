@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Edit Schedule</h3>
    <p>Update doctor schedule settings.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('schedules.update', $schedule) }}" method="POST">
        @csrf
        @method('PUT')
        @include('schedules._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Update Schedule</button>
            <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection