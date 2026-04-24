@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="page-title mb-4">
    <h3>Edit User</h3>
    <p>Update user account details and role.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        @include('users._form')

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection