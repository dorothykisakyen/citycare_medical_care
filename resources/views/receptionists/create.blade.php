@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Create Receptionist</h3>
    <p>Add a receptionist account.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('receptionists.store') }}" method="POST">
        @csrf
        @include('receptionists._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Save Receptionist</button>
            <a href="{{ route('receptionists.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection