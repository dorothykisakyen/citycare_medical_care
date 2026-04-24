@extends('layouts.app')

@section('title', 'Doctors')

@section('content')
<div class="index-content-wrapper" style="display: block; width: 100%; clear: both;">
    
    {{-- Page Header: Displays the section title and the "Add Doctor" action button --}}
    <div class="page-title d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Doctors</h3>
            <p>Manage doctor profiles, departments.</p>
        </div>
        <a href="{{ route('doctors.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>Add Doctor
        </a>
    </div>

    {{-- Filter Panel: Multi-criteria form to search by keywords, department, or account status --}}
    <div class="dashboard-panel mb-4">
        <form method="GET" action="{{ route('doctors.index') }}">
            <div class="row g-3">
                {{-- Text Search: Checks name, ID number, phone, and medical specialization --}}
                <div class="col-md-4">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Name, doctor no., phone, specialization...">
                </div>

                {{-- Department Filter: Narrow down the list to specific clinical units --}}
                <div class="col-md-3">
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ (string)request('department_id') === (string)$dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status Filter: Toggle between Active and Inactive medical profiles --}}
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        <option value="1" {{ $status === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $status === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Submission Button: Applies selected filters to the results --}}
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Data Table Section: Lists doctor records with consultation fees and account statuses --}}
    <div class="dashboard-panel table-card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        {{-- Row Indexing: Calculated based on current pagination page --}}
                        <th>#</th>
                        <th>Doctor No.</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Specialization</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th width="220">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doctor)
                        <tr>
                            <td>{{ $loop->iteration + ($doctors->firstItem() - 1) }}</td>
                            <td class="fw-bold">{{ $doctor->doctor_number }}</td>
                            <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                            <td>{{ $doctor->department->name ?? 'N/A' }}</td>
                            <td>{{ $doctor->specialization }}</td>
                            {{-- Currency Formatting: Shows fees in Uganda Shillings --}}
                            <td>UGX {{ number_format($doctor->consultation_fee, 2) }}</td>
                            
                            {{-- Status Badge: Uses soft-pill styling for high visual contrast --}}
                            <td>
                                <span class="badge {{ $doctor->status ? 'badge-soft-success' : 'badge-soft-danger' }} rounded-pill px-3 py-2">
                                    {{ $doctor->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            {{-- CRUD Actions: View, Edit, and Secure Delete --}}
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    
                                    {{-- Delete Form: Includes CSRF protection and a JavaScript confirm dialog --}}
                                    <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" onsubmit="return confirm('Delete this doctor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Empty State: Displayed when no records match the criteria --}}
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="fa-solid fa-user-doctor fa-2x d-block mb-2 opacity-50"></i>
                                No doctors found for your search/filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination: Displays navigation links if results exceed per-page limit --}}
        <div class="mt-3 p-3">
            {{ $doctors->links() }}
        </div>
    </div>

    <div style="clear: both;"></div>
</div>
@endsection
