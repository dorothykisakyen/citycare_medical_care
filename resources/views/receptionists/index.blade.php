@extends('layouts.app')

@section('title', 'Receptionists Management')

@section('content')

<div class="d-flex flex-column" style="min-height: 80vh;">

    <div class="page-title d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Receptionists</h3>
            <p class="text-muted">Manage front desk staff handling appointments and bookings.</p>
        </div>
        <a href="{{ route('receptionists.create') }}" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-plus me-2"></i>Add Receptionist
        </a>
    </div>

    <div class="dashboard-panel mb-4 shadow-sm bg-white p-4 rounded">
        <form method="GET" action="{{ route('receptionists.index') }}">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Search by name, email or ID...">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="1" {{ $status === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $status === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>

  
    <div class="dashboard-panel table-card shadow-sm mb-auto bg-white rounded overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Receptionist No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Shift</th>
                        <th>Status</th>
                        <th width="150" class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($receptionists as $receptionist)
                    <tr>
                        <td class="ps-4 fw-bold text-primary">{{ $receptionist->receptionist_number }}</td>
                        <td>{{ $receptionist->first_name }} {{ $receptionist->last_name }}</td>
                        <td>{{ $receptionist->email }}</td>
                        <td>{{ $receptionist->shift ?: 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $receptionist->status ? 'badge-soft-success' : 'badge-soft-danger' }} rounded-pill px-3 py-2">
                                {{ $receptionist->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="pe-4">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('receptionists.show', $receptionist) }}" class="btn btn-sm btn-outline-info border-0" title="View"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('receptionists.edit', $receptionist) }}" class="btn btn-sm btn-outline-primary border-0" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('receptionists.destroy', $receptionist) }}" method="POST" onsubmit="return confirm('Delete this receptionist?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger border-0" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-user-tag fa-2x d-block mb-2 opacity-50"></i>
                            No receptionists found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($receptionists->hasPages())
            <div class="p-3 border-top">
                {{ $receptionists->links() }}
            </div>
        @endif
    </div>

    <div class="clearfix"></div>
</div>
@endsection
