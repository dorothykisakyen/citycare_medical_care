@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Global Search Results</h3>
    <p>Search results for: <strong>{{ $q ?: 'No query entered' }}</strong></p>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="dashboard-panel table-card">
            <h5>Doctors</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Doctor No.</th>
                        <th>Name</th>
                        <th>Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($doctors as $doctor)
                        <tr>
                            <td>{{ $doctor->doctor_number }}</td>
                            <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                            <td>{{ $doctor->department->name ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">No doctor results.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="dashboard-panel table-card">
            <h5>Patients</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Patient No.</th>
                        <th>Name</th>
                        <th>Phone</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>{{ $patient->patient_number }}</td>
                            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                            <td>{{ $patient->phone }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">No patient results.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="dashboard-panel table-card">
            <h5>Departments</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($departments as $department)
                        <tr>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->description ?: 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center text-muted">No department results.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="dashboard-panel table-card">
            <h5>Appointments</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->patient->first_name ?? '' }} {{ $appointment->patient->last_name ?? '' }}</td>
                            <td>{{ $appointment->doctor->first_name ?? '' }} {{ $appointment->doctor->last_name ?? '' }}</td>
                            <td>{{ ucfirst($appointment->status) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">No appointment results.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="dashboard-panel table-card">
            <h5>Payments</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->patient->first_name ?? '' }} {{ $payment->patient->last_name ?? '' }}</td>
                            <td>UGX {{ number_format($payment->amount, 2) }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</td>
                            <td>{{ ucfirst($payment->status) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">No payment results.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection