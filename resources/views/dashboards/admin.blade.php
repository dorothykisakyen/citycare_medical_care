@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
{{-- Header: Overview of the medical center's current performance metrics --}}
<div class="page-title mb-4">
    <h3><i class="fa-solid fa-gauge-high me-2 text-primary"></i>Admin Dashboard</h3>
    <p>Full overview of patients, staff, appointments, treatment, schedules, and revenue.</p>
</div>

{{-- Summary Cards Row: Displays key counts and totals using a loop for consistency --}}
<div class="row g-4 mb-4">
    @foreach([
        ['Total Patients', $totalPatients ?? 0, 'All registered patients', 'fa-user-injured', 'text-primary'],
        ['Total Doctors', $totalDoctors ?? 0, 'Doctors in clinic', 'fa-user-doctor', 'text-success'],
        ['Patients Treated', $totalPatientsTreated ?? 0, 'Patients with consultations', 'fa-notes-medical', 'text-warning'],
        ['Total Revenue', 'UGX ' . number_format($totalRevenue ?? 0), 'All paid transactions', 'fa-money-bill-wave', 'text-info'],
        ['Departments', $totalDepartments ?? 0, 'Clinic service units', 'fa-building-user', 'text-secondary'],
        ['Receptionists', $totalReceptionists ?? 0, 'Front desk staff', 'fa-headset', 'text-primary'],
        ['Cashiers', $totalCashiers ?? 0, 'Billing staff', 'fa-cash-register', 'text-danger'],
        ['Appointments', $totalAppointments ?? 0, 'All bookings', 'fa-calendar-check', 'text-success'],
    ] as [$label, $value, $note, $icon, $color])
    <div class="col-md-6 col-xl-3">
        <div class="dashboard-panel h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-1">{{ $label }}</p>
                    <h4 class="mb-0">{{ $value }}</h4>
                    <small class="text-muted">{{ $note }}</small>
                </div>
                <i class="fa-solid {{ $icon }} fa-2x {{ $color }}"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Charts Row 1: Patient demographics and appointment statistics --}}
<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="dashboard-panel chart-card">
            <h5><i class="fa-solid fa-chart-simple me-2 text-primary"></i>Registered vs Treated</h5>
            <div style="height: 280px; position: relative;">
                <canvas id="registeredTreatedChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="dashboard-panel chart-card">
            <h5><i class="fa-solid fa-venus-mars me-2 text-info"></i>Patient Gender</h5>
            <div style="height: 280px; position: relative;">
                <canvas id="patientGenderChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="dashboard-panel chart-card">
            <h5><i class="fa-solid fa-calendar-check me-2 text-success"></i>Appointment Status</h5>
            <div style="height: 280px; position: relative;">
                <canvas id="appointmentStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Charts Row 2: Financial trends and staff distribution --}}
<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="dashboard-panel chart-card">
            <h5><i class="fa-solid fa-sack-dollar me-2 text-success"></i>Revenue Overview</h5>
            <div style="height: 320px; position: relative;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="dashboard-panel chart-card">
            <h5><i class="fa-solid fa-user-doctor me-2 text-primary"></i>Doctors by Gender</h5>
            <div style="height: 320px; position: relative;">
                <canvas id="doctorGenderChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Recent Data Tables: Quick view of the latest system activity --}}
<div class="row g-4">
    <div class="col-lg-7">
        <div class="dashboard-panel table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fa-solid fa-calendar-days me-2 text-primary"></i>Recent Appointments</h5>
                <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fa-solid fa-eye me-1"></i>View All
                </a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr><th>Patient</th><th>Doctor</th><th>Department</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentAppointments as $appointment)
                        <tr>
                            <td>{{ $appointment->patient->first_name ?? '' }} {{ $appointment->patient->last_name ?? '' }}</td>
                            <td>Dr. {{ $appointment->doctor->first_name ?? '' }} {{ $appointment->doctor->last_name ?? '' }}</td>
                            <td>{{ $appointment->department->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-primary text-capitalize">{{ $appointment->status }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">No appointments found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="dashboard-panel table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fa-solid fa-money-bill-wave me-2 text-success"></i>Recent Payments</h5>
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-success">
                    <i class="fa-solid fa-eye me-1"></i>View All
                </a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr><th>Patient</th><th>Amount</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments as $payment)
                        <tr>
                            <td>{{ $payment->patient->first_name ?? '' }} {{ $payment->patient->last_name ?? '' }}</td>
                            <td>UGX {{ number_format($payment->amount, 2) }}</td>
                            <td><span class="badge bg-success text-capitalize">{{ $payment->status ?? 'paid' }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted">No payments found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Chart.js: Used for data visualization --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    {{--Global settings to ensure layout stability and responsiveness --}}
    const globalOptions = {
        responsive: true,
        maintainAspectRatio: false,
        resizeDelay: 200
    };

    {{-- Chart 1: Bar chart for patient registration vs successful consultations --}}
    new Chart(document.getElementById('registeredTreatedChart'), {
        type: 'bar',
        data: {
            labels: ['Registered', 'Treated'],
            datasets: [{
                label: 'Patients',
                data: [Number("{{ $totalPatients ?? 0 }}"), Number("{{ $totalPatientsTreated ?? 0 }}")],
                backgroundColor: ['#0ea5a4', '#16a34a'],
                borderRadius: 8
            }]
        },
        options: {
            ...globalOptions,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    {{-- Chart 2: Doughnut chart for patient gender distribution --}}
    new Chart(document.getElementById('patientGenderChart'), {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [Number("{{ $malePatients ?? 0 }}"), Number("{{ $femalePatients ?? 0 }}")],
                backgroundColor: ['#0ea5a4', '#06b6d4']
            }]
        },
        options: globalOptions
    });

    {{-- Chart 3: Pie chart for tracking booking success and cancellation rates --}}
    new Chart(document.getElementById('appointmentStatusChart'), {
        type: 'pie',
        data: {
            labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
            datasets: [{
                data: [
                    Number("{{ $pendingAppointments ?? 0 }}"), 
                    Number("{{ $confirmedAppointments ?? 0 }}"), 
                    Number("{{ $completedAppointments ?? 0 }}"), 
                    Number("{{ $cancelledAppointments ?? 0 }}")
                ],
                backgroundColor: ['#f59e0b', '#0ea5a4', '#16a34a', '#ef4444']
            }]
        },
        options: globalOptions
    });

    {{-- Chart 4: Line chart for revenue growth trends over time --}}
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: ['Today', 'This Week', 'This Month', 'Total'],
            datasets: [{
                label: 'Revenue UGX',
                data: [
                    Number("{{ $todayRevenue ?? 0 }}"), 
                    Number("{{ $weeklyRevenue ?? 0 }}"), 
                    Number("{{ $monthlyRevenue ?? 0 }}"), 
                    Number("{{ $totalRevenue ?? 0 }}")
                ],
                borderColor: '#0ea5a4',
                backgroundColor: 'rgba(14, 165, 164, 0.18)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            ...globalOptions,
            scales: { 
                y: { 
                    beginAtZero: true, 
                    ticks: { callback: (v) => 'UGX ' + v.toLocaleString() } 
                } 
            }
        }
    });

    {{-- Chart 5: Bar chart for staff demographic distribution --}}
    new Chart(document.getElementById('doctorGenderChart'), {
        type: 'bar',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                label: 'Doctors',
                data: [Number("{{ $maleDoctors ?? 0 }}"), Number("{{ $femaleDoctors ?? 0 }}")],
                backgroundColor: ['#0ea5a4', '#06b6d4'],
                borderRadius: 8
            }]
        },
        options: {
            ...globalOptions,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
});
</script>
@endpush
