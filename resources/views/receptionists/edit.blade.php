@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Edit Receptionist</h3>
    <p>Update receptionist details.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('receptionists.update', $receptionist) }}" method="POST">
        @csrf
        @method('PUT')
        @include('receptionists._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Update Receptionist</button>
            <a href="{{ route('receptionists.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection