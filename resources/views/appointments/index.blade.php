@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
<div class="d-flex flex-column" style="min-height: 80vh;">
    
    {{-- Page Header: Title and primary action button for booking new appointments --}}
    <div class="page-title d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Appointments</h3>
            <p class="text-muted">Manage bookings, updates, cancellations, and doctor time control.</p>
        </div>
        <a href="{{ route('appointments.create') }}" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-plus me-2"></i>Book Appointment
        </a>
    </div>

    {{-- Filter Panel: Multi-criteria search for patients, doctors, status, and specific dates --}}
    <div class="dashboard-panel mb-4 shadow-sm bg-white p-4 rounded">
        <form method="GET" action="{{ route('appointments.index') }}">
            <div class="row g-3">
                {{-- Search by Name --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Patient or doctor name...">
                </div>

                {{-- Filter by Doctor specialization --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Doctor</label>
                    <select name="doctor_id" class="form-select">
                        <option value="">All Doctors</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ (string)$doctorId === (string)$doctor->id ? 'selected' : '' }}>
                                {{ $doctor->first_name }} {{ $doctor->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter by Workflow Status --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select text-capitalize">
                        <option value="">All Statuses</option>
                        @foreach(['pending','confirmed','completed','cancelled'] as $statusOption)
                            <option value="{{ $statusOption }}" {{ $status === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter by Specific Date --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Date</label>
                    <input type="date" name="appointment_date" class="form-control" value="{{ $date }}">
                </div>

                {{-- Form Submission --}}
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="fa-solid fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Data Table: List of appointments with dynamic status coloring and action tools --}}
    <div class="dashboard-panel table-card shadow-sm mb-auto bg-white rounded overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Patient</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Time Slot</th>
                        <th>Status</th>
                        <th width="150" class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            {{-- Patient Identification --}}
                            <td class="ps-4 fw-bold text-dark">
                                {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                            </td>
                            
                            {{-- Assigned Doctor --}}
                            <td>Dr. {{ $appointment->doctor->first_name }} {{ $appointment->doctor->last_name }}</td>
                            
                            {{-- Appointment Date formatted for clarity --}}
                            <td>{{ $appointment->appointment_date->format('d M Y') }}</td>
                            
                            {{-- Time Slot: Formatted to HH:MM format using substr --}}
                            <td>{{ substr($appointment->appointment_time,0,5) }} - {{ substr($appointment->end_time,0,5) }}</td>
                            
                            {{-- Status Badge: Dynamic colors using PHP match expression --}}
                            <td>
                                @php
                                    $statusClass = match($appointment->status) {
                                        'completed' => 'badge-soft-success',
                                        'confirmed' => 'badge-soft-primary',
                                        'cancelled' => 'badge-soft-danger',
                                        default     => 'badge-soft-warning',
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 text-capitalize">
                                    {{ $appointment->status }}
                                </span>
                            </td>

                            {{-- Actions Menu: Show, Edit, and Delete options --}}
                            <td class="pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-outline-info border-0" title="View"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-outline-primary border-0" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    
                                    {{-- Delete operation wrapped in a form for security (CSRF/METHOD protection) --}}
                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Delete this appointment?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger border-0" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Empty State: Displayed when no records match the filter criteria --}}
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-calendar-day fa-2x d-block mb-2 opacity-50"></i>
                                No appointments found for the selected criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination: Rendered only if result count exceeds records-per-page --}}
        @if($appointments->hasPages())
            <div class="p-3 border-top">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>

    <div class="clearfix"></div>
</div>
@endsection
