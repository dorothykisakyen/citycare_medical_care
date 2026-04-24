@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Create Admin</h3>
    <p>Add another administrator account.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('admins.store') }}" method="POST">
        @csrf
        @include('admins._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Save Admin</button>
            <a href="{{ route('admins.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection