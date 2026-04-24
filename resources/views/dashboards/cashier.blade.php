@extends('layouts.app')

@section('title', 'Cashier Dashboard')

@section('content')
{{-- Page Header: Displays the dashboard title and a brief role-based description --}}
<div class="page-title mb-4">
    <h3><i class="fa-solid fa-cash-register me-2 text-primary"></i>Cashier Dashboard</h3>
    <p>Record and track all payments made by patients.</p>
</div>

{{-- Financial Summary Row: Displays revenue breakdown by time periods (Today, Weekly, Monthly, Total) --}}
<div class="row g-4 mb-4">
    {{-- Daily Revenue Metric --}}
    <div class="col-md-6 col-xl-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1"><i class="fa-solid fa-calendar-day me-2 text-primary"></i>Today Revenue</p>
            <h3>UGX {{ number_format($todayPayments ?? 0, 2) }}</h3>
        </div>
    </div>
    {{-- Weekly Revenue Metric --}}
    <div class="col-md-6 col-xl-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1"><i class="fa-solid fa-calendar-week me-2 text-success"></i>Weekly Revenue</p>
            <h3>UGX {{ number_format($weeklyPayments ?? 0, 2) }}</h3>
        </div>
    </div>
    {{-- Monthly Revenue Metric --}}
    <div class="col-md-6 col-xl-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1"><i class="fa-solid fa-calendar-days me-2 text-info"></i>Monthly Revenue</p>
            <h3>UGX {{ number_format($monthlyPayments ?? 0, 2) }}</h3>
        </div>
    </div>
    {{-- Cumulative Revenue Metric --}}
    <div class="col-md-6 col-xl-3">
        <div class="dashboard-panel">
            <p class="text-muted mb-1"><i class="fa-solid fa-money-bill-wave me-2 text-warning"></i>Total Revenue</p>
            <h3>UGX {{ number_format($totalPayments ?? 0, 2) }}</h3>
        </div>
    </div>
</div>

{{-- Operational Stats Row: Provides a count of payment records categorized by their current status --}}
<div class="row g-4 mb-4">
    {{-- Overall transaction count --}}
    <div class="col-md-3">
        <div class="dashboard-panel text-center">
            <i class="fa-solid fa-receipt fa-2x text-primary mb-2"></i>
            <p class="text-muted mb-1">Total Payments</p>
            <h3>{{ $paymentCount ?? 0 }}</h3>
        </div>
    </div>
    {{-- Successfully processed payments --}}
    <div class="col-md-3">
        <div class="dashboard-panel text-center">
            <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
            <p class="text-muted mb-1">Paid Payments</p>
            <h3>{{ $paidPayments ?? 0 }}</h3>
        </div>
    </div>
    {{-- Payments awaiting processing --}}
    <div class="col-md-3">
        <div class="dashboard-panel text-center">
            <i class="fa-solid fa-clock fa-2x text-warning mb-2"></i>
            <p class="text-muted mb-1">Pending Payments</p>
            <h3>{{ $pendingPayments ?? 0 }}</h3>
        </div>
    </div>
    {{-- Unsuccessful or cancelled transactions --}}
    <div class="col-md-3">
        <div class="dashboard-panel text-center">
            <i class="fa-solid fa-circle-xmark fa-2x text-danger mb-2"></i>
            <p class="text-muted mb-1">Failed Payments</p>
            <h3>{{ $failedPayments ?? 0 }}</h3>
        </div>
    </div>
</div>

{{-- Recent Transactions Table: A detailed list of the most recent financial entries --}}
<div class="dashboard-panel table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0"><i class="fa-solid fa-money-check-dollar me-2 text-success"></i>Recent Patient Payments</h5>
        {{-- Navigation link to the full payments master list --}}
        <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-primary">
            <i class="fa-solid fa-eye me-1"></i>View All
        </a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Appointment</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPayments as $payment)
                <tr>
                    {{-- Patient Full Name --}}
                    <td>
                        {{ $payment->patient->first_name ?? '' }} {{ $payment->patient->last_name ?? '' }}
                    </td>
                    {{-- Linked Appointment Reference Number --}}
                    <td>{{ $payment->appointment->appointment_number ?? 'N/A' }}</td>
                    {{-- Transaction Value in UGX --}}
                    <td>UGX {{ number_format($payment->amount ?? 0, 2) }}</td>
                    {{-- Mode of Payment (Cash, Mobile Money, etc.) --}}
                    <td>{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                    {{-- Payment Date: Prioritizes explicit payment_date over created_at timestamp --}}
                    <td>
                        {{ isset($payment->payment_date) ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : $payment->created_at->format('d M Y') }}
                    </td>
                    {{-- Dynamic Status Badge: Color changes based on payment status --}}
                    <td>
                        @php
                            $statusClass = match($payment->status) {
                                'paid'   => 'badge-soft-success',
                                'failed' => 'badge-soft-danger',
                                default  => 'badge-soft-warning',
                            };
                        @endphp
                        <span class="badge {{ $statusClass }} text-capitalize">
                            {{ $payment->status }}
                        </span>
                    </td>
                </tr>
                @empty
                {{-- Empty State: Displayed when no payment records exist in the system --}}
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No payments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
