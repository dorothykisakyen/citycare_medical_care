@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="page-title mb-4">
    <h3>Create User</h3>
    <p>Add a new system user and assign a role.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        @include('users._form')

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save User</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection