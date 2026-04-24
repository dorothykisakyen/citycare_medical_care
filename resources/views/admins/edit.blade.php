@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Edit Admin</h3>
    <p>Update administrator details.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('admins.update', $admin) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admins._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Update Admin</button>
            <a href="{{ route('admins.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection