@extends('layouts.app')

@section('title', 'Edit Doctor')

@section('content')
<div class="page-title mb-4">
    <h3>Edit Doctor</h3>
    <p>Update doctor details.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('doctors.update', $doctor) }}" method="POST">
            @csrf
            @method('PUT')

            @include('doctors._form')

            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="{{ route('doctors.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Doctor</button>
            </div>
        </form>
    </div>
</div>
@endsection