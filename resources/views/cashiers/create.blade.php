@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Create Cashier</h3>
    <p>Add a cashier account.</p>
</div>

<div class="dashboard-panel">
    <form action="{{ route('cashiers.store') }}" method="POST">
        @csrf
        @include('cashiers._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Save Cashier</button>
            <a href="{{ route('cashiers.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection