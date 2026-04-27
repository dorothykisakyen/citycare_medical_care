@extends('layouts.app')

@section('title', 'Reports')

@section('content')
{{-- Page Header: Information about available report types and export formats --}}
<div class="page-title">
    <h3>Reports</h3>
    <p>Generate daily appointment, doctor schedule, payment, and patient visit reports in PDF, CSV, or Excel.</p>
</div>

<div class="row g-4">
    {{-- Daily Appointments Report: Filter by date range to track clinic bookings --}}
    <div class="col-lg-3">
        <div class="dashboard-panel">
            <h5>Daily Appointments</h5>
            <form method="GET" action="{{ route('reports.daily-appointments') }}" class="d-grid gap-3">
                <input type="date" name="date_from" class="form-control">
                <input type="date" name="date_to" class="form-control">
                <select name="format" class="form-select">
                    <option value="pdf">PDF</option>
                    <option value="csv">CSV</option>
                </select>
                <button class="btn btn-primary">Generate</button>
            </form>
        </div>
    </div>

    {{-- Doctor Schedules Report: Exports duty rosters and shift allocations for medical staff --}}
    <div class="col-lg-3">
        <div class="dashboard-panel">
            <h5>Doctor Schedules</h5>
            <form method="GET" action="{{ route('reports.doctor-schedules') }}" class="d-grid gap-3">
                <input type="date" name="date_from" class="form-control">
                <input type="date" name="date_to" class="form-control">
                <select name="format" class="form-select">
                    <option value="pdf">PDF</option>
                    <option value="csv">CSV</option>
                </select>
                <button class="btn btn-success">Generate</button>
            </form>
        </div>
    </div>

    {{-- Payments Report: Financial auditing tool to track revenue and transaction methods --}}
    <div class="col-lg-3">
        <div class="dashboard-panel">
            <h5>Payments</h5>
            <form method="GET" action="{{ route('reports.payment-report') }}" class="d-grid gap-3">
                <input type="date" name="date_from" class="form-control">
                <input type="date" name="date_to" class="form-control">
                <select name="format" class="form-select">
                    <option value="pdf">PDF</option>
                    <option value="csv">CSV</option>
                </select>
                <button class="btn btn-warning">Generate</button>
            </form>
        </div>
    </div>

    {{-- Patient Visit Report: Detailed log of clinical consultations and patient flow --}}
    <div class="col-lg-3">
        <div class="dashboard-panel">
            <h5>Patient Visit</h5>
            <form method="GET" action="{{ route('reports.patient-visits') }}" class="d-grid gap-3">
                <input type="date" name="date_from" class="form-control">
                <input type="date" name="date_to" class="form-control">
                <select name="format" class="form-select">
                    <option value="pdf">PDF</option>
                    <option value="csv">CSV</option>
                </select>
                <button class="btn btn-dark">Generate</button>
            </form>
        </div>
    </div>
</div>
@endsection
