@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Create Schedule</h3>
    <p>Define a consultation schedule for a doctor.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('schedules.store') }}" method="POST">
        @csrf
        @include('schedules._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Save Schedule</button>
            <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection