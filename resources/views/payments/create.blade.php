@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Record Payment</h3>
    <p>Add a new patient payment record.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        @include('payments._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Save Payment</button>
            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection