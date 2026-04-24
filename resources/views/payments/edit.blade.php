@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Edit Payment</h3>
    <p>Update payment details and status.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('payments.update', $payment) }}" method="POST">
        @csrf
        @method('PUT')
        @include('payments._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Update Payment</button>
            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection