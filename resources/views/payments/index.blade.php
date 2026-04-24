@extends('layouts.app')

@section('title', 'Payments Management')

@section('content')
<div class="d-flex flex-column" style="min-height: 80vh;">
    
    {{-- Page Header: Title and primary button to record a new transaction --}}
    <div class="page-title d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Payments</h3>
            <p class="text-muted">Record and track patient payments with search, filters, and pagination.</p>
        </div>
        <a href="{{ route('payments.create') }}" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-plus me-2"></i>Add Payment
        </a>
    </div>

    {{-- Filter Panel: Enables searching by patient name/reference and filtering by status or method --}}
    <div class="dashboard-panel mb-4 shadow-sm bg-white p-4 rounded">
        <form method="GET" action="{{ route('payments.index') }}">
            <div class="row g-3">
                {{-- Search: General text search for patient names or reference IDs --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Search patient or reference...">
                </div>

                {{-- Status Filter: Dropdown for transaction lifecycle states --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select text-capitalize">
                        <option value="">All Statuses</option>
                        @foreach(['paid','pending','failed'] as $statusItem)
                            <option value="{{ $statusItem }}" {{ $status === $statusItem ? 'selected' : '' }}>{{ $statusItem }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Payment Method Filter: Specifically for financial reporting by mode of payment --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Payment Method</label>
                    <select name="payment_method" class="form-select">
                        <option value="">Select Payment Method</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="mobile_money" {{ request('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                        <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                        <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Bank</option>
                    </select>
                </div>

                {{-- Submission Button --}}
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="fa-solid fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Data Table: Displays the list of financial records --}}
    <div class="dashboard-panel table-card shadow-sm mb-auto bg-white rounded overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Patient</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th width="150" class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            {{-- Identification: Full patient name --}}
                            <td class="ps-4 fw-bold text-dark">
                                {{ $payment->patient->first_name }} {{ $payment->patient->last_name }}
                            </td>

                            {{-- Financial Data: Formatted amount with UGX prefix --}}
                            <td class="text-success fw-medium">UGX {{ number_format($payment->amount, 2) }}</td>

                            {{-- Payment Mode: Formats slug strings into readable titles (e.g., mobile_money -> Mobile Money) --}}
                            <td>{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</td>

                            {{-- Timestamp: Explicit payment date --}}
                            <td>{{ $payment->payment_date->format('d M Y') }}</td>

                            {{-- Dynamic Status Badge: Colors mapped via PHP match expression --}}
                            <td>
                                @php
                                    $statusClass = match($payment->status) {
                                        'paid'   => 'badge-soft-success',
                                        'failed' => 'badge-soft-danger',
                                        default  => 'badge-soft-warning',
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 text-capitalize">
                                    {{ $payment->status }}
                                </span>
                            </td>

                            {{-- Action Menu: Tools to view, edit, or delete a payment record --}}
                            <td class="pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-info border-0" title="View"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-outline-primary border-0" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    
                                    {{-- Secure Delete: Wrapped in a POST form with CSRF/Method Spoofing --}}
                                    <form action="{{ route('payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Delete this payment?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger border-0" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Empty State: Displayed when no transactions exist or match filters --}}
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-money-bill-transfer fa-2x d-block mb-2 opacity-50"></i>
                                No payments found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination: Displayed if record count exceeds the per-page limit --}}
        @if($payments->hasPages())
            <div class="p-3 border-top">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

    <div class="clearfix"></div>
</div>
@endsection
