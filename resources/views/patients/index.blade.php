@extends('layouts.app')

@section('title', 'Patients Management')

@section('content')
<div class="d-flex flex-column" style="min-height: 80vh;">
    
    {{-- Page Header: Section title and primary action button for registration --}}
    <div class="page-title d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Patients</h3>
            <p class="text-muted">Manage patient records.</p>
        </div>
        <a href="{{ route('patients.create') }}" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-plus me-2"></i>Add Patient
        </a>
    </div>

    {{-- Filter Panel: Multi-parameter search and status filtering --}}
    <div class="dashboard-panel mb-4 shadow-sm bg-white p-4 rounded">
        <form method="GET" action="{{ route('patients.index') }}">
            <div class="row g-3">
                {{-- Search Input: Checks against name, patient ID, or phone number --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Name, ID, or phone...">
                </div>

                {{-- Gender Filter: Specifically for demographic narrowing --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">All Genders</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                {{-- Status Filter: Toggle between Active/Inactive patient files --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Form Actions: Submission and full reset buttons --}}
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </div>
        </form>
    </div>

    {{-- Main Data Table: List of patient profiles with soft-color status badges --}}
    <div class="dashboard-panel table-card shadow-sm mb-auto bg-white rounded overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        {{-- Row Indexing: Adjusted to match the current pagination page --}}
                        <th class="ps-4">#</th>
                        <th>Patient No.</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th width="150" class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>{{ $loop->iteration + ($patients->firstItem() - 1) }}</td>
                            <td><span class="fw-bold text-primary">{{ $patient->patient_number }}</span></td>
                            <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                            <td>{{ ucfirst($patient->gender) }}</td>
                            <td>{{ $patient->phone }}</td>
                            
                            {{-- Status Badge: Uses soft green for active and soft red for inactive --}}
                            <td>
                                <span class="badge {{ $patient->status ? 'badge-soft-success' : 'badge-soft-danger' }} rounded-pill px-3 py-2">
                                    {{ $patient->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            {{-- CRUD Actions: View, Edit, and Secure Delete --}}
                            <td class="pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-outline-info border-0" title="View"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-outline-primary border-0" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    
                                    {{-- Delete Form: Standard Laravel method spoofing with JS confirmation --}}
                                    <form action="{{ route('patients.destroy', $patient) }}" method="POST" onsubmit="return confirm('Delete this patient?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger border-0" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Empty State: Displayed when no records match the database query --}}
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-users-slash fa-2x d-block mb-2 opacity-50"></i>
                                No patient records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links: Renders only if records span multiple pages --}}
        @if($patients->hasPages())
            <div class="p-3 border-top">
                {{ $patients->links() }}
            </div>
        @endif
    </div>

    <div class="clearfix"></div>
</div>
@endsection
