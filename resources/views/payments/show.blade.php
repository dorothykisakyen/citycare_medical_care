@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Payment Details</h3>
    <p>View payment transaction information.</p>
</div>

<div class="dashboard-panel">
    <div class="row g-4">
        <div class="col-md-6"><label class="form-label fw-semibold">Patient</label><input class="form-control" value="{{ $payment->patient->first_name }} {{ $payment->patient->last_name }}" readonly></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Amount</label><input class="form-control" value="UGX {{ number_format($payment->amount, 2) }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Method</label><input class="form-control" value="{{ ucwords(str_replace('_',' ', $payment->payment_method)) }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Date</label><input class="form-control" value="{{ $payment->payment_date->format('d M Y') }}" readonly></div>
        <div class="col-md-4"><label class="form-label fw-semibold">Status</label><input class="form-control" value="{{ ucfirst($payment->status) }}" readonly></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Reference</label><input class="form-control" value="{{ $payment->transaction_reference ?: 'N/A' }}" readonly></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Cashier</label><input class="form-control" value="{{ $payment->cashier?->first_name }} {{ $payment->cashier?->last_name }}" readonly></div>
        <div class="col-12"><label class="form-label fw-semibold">Notes</label><textarea class="form-control" rows="3" readonly>{{ $payment->notes ?: 'N/A' }}</textarea></div>
    </div>
</div>
@endsection