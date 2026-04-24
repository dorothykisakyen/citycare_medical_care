@extends('layouts.app')

@section('title', 'Doctor Schedules')

@section('content')
<div class="d-flex flex-column" style="min-height: 80vh;">
    
    {{-- Page Header: Title and primary button for creating new doctor duty rosters --}}
    <div class="page-title d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Schedules</h3>
            <p class="text-muted">Define consultation schedules for doctors.</p>
        </div>
        <a href="{{ route('schedules.create') }}" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-plus me-2"></i>Add Schedule
        </a>
    </div>

    {{-- Filter Panel: Narrow down schedules by specific medical professionals or specific days of the week --}}
    <div class="dashboard-panel mb-4 shadow-sm bg-white p-4 rounded">
        <form method="GET" action="{{ route('schedules.index') }}">
            <div class="row g-3">
                {{-- Doctor Selection Filter --}}
                <div class="col-md-5">
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

                {{-- Day of Week Selection Filter --}}
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Day of Week</label>
                    <select name="day_of_week" class="form-select">
                        <option value="">All Days</option>
                        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $dayName)
                            <option value="{{ $dayName }}" {{ $day === $dayName ? 'selected' : '' }}>{{ $dayName }}</option>
                        @endforeach
                    </select>
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

    {{-- Data Table: Detailed overview of shift times, slot intervals, and clinic availability --}}
    <div class="dashboard-panel table-card shadow-sm mb-auto bg-white rounded overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Doctor</th>
                        <th>Department</th>
                        <th>Day</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Slot</th>
                        <th>Status</th>
                        <th width="150" class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                        <tr>
                            {{-- Identification and Specialty --}}
                            <td class="ps-4 fw-bold text-primary">
                                {{ $schedule->doctor->first_name }} {{ $schedule->doctor->last_name }}
                            </td>
                            <td>{{ $schedule->doctor->department->name ?? 'N/A' }}</td>
                            
                            {{-- Schedule Configuration --}}
                            <td>{{ $schedule->day_of_week }}</td>
                            {{-- Formatted Time: Strips seconds to show HH:MM format --}}
                            <td>{{ substr($schedule->start_time,0,5) }}</td>
                            <td>{{ substr($schedule->end_time,0,5) }}</td>
                            <td>{{ $schedule->slot_duration }} min</td>

                            {{-- Availability Badge: Green for Available, Red for Closed/Leave --}}
                            <td>
                                <span class="badge {{ $schedule->is_available ? 'badge-soft-success' : 'badge-soft-danger' }} rounded-pill px-3 py-2">
                                    {{ $schedule->is_available ? 'Available' : 'Closed' }}
                                </span>
                            </td>

                            {{-- Actions Menu: Edit or Delete specific schedule entries --}}
                            <td class="pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('schedules.edit', $schedule) }}" class="btn btn-sm btn-outline-primary border-0" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    
                                    {{-- Secure Delete: Standard Laravel method spoofing with JS confirmation --}}
                                    <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Delete this schedule?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger border-0" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Placeholder displayed when no results match the filter parameters --}}
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-calendar-xmark fa-2x d-block mb-2 opacity-50"></i>
                                No schedules found matching your filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination: Navigates through multiple pages of shift data --}}
        @if($schedules->hasPages())
            <div class="p-3 border-top">
                {{ $schedules->links() }}
            </div>
        @endif
    </div>

    <div class="clearfix"></div>
</div>
@endsection
