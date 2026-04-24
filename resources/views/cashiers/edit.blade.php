@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Edit Cashier</h3>
    <p>Update cashier details.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('cashiers.update', $cashier) }}" method="POST">
        @csrf
        @method('PUT')
        @include('cashiers._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Update Cashier</button>
            <a href="{{ route('cashiers.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection