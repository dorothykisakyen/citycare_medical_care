@extends('layouts.app')

@section('title', 'Cashiers Management')

@section('content')
<div class="d-flex flex-column" style="min-height: 80vh;">
    
    {{-- Page Header: Title and primary action button for adding new cashier staff --}}
    <div class="page-title d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Cashiers</h3>
            <p class="text-muted">Manage cashier staff responsible for recording and tracking payments.</p>
        </div>
        <a href="{{ route('cashiers.create') }}" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-plus me-2"></i>Add Cashier
        </a>
    </div>

    {{-- Filter Panel: Allows searching by personal details and filtering by account status --}}
    <div class="dashboard-panel mb-4 shadow-sm bg-white p-4 rounded">
        <form method="GET" action="{{ route('cashiers.index') }}">
            <div class="row g-3">
                {{-- Text Search: Filters by Name, Email, or Employee ID --}}
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Search by name, email or ID...">
                </div>

                {{-- Status Filter: Toggle between Active and Inactive accounts --}}
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="1" {{ $status === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $status === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Submission Button --}}
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Main Data Table: List of all cashier records with status badges and action links --}}
    <div class="dashboard-panel table-card shadow-sm mb-auto bg-white rounded overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Cashier No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Shift</th>
                        <th>Status</th>
                        <th width="150" class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cashiers as $cashier)
                        <tr>
                            {{-- Unique Employee Identifier --}}
                            <td class="ps-4 fw-bold text-primary">{{ $cashier->cashier_number }}</td>
                            
                            {{-- Personal Details --}}
                            <td>{{ $cashier->first_name }} {{ $cashier->last_name }}</td>
                            <td>{{ $cashier->email }}</td>
                            
                            {{-- Shift Assignment: Defaults to N/A if not specified --}}
                            <td>{{ $cashier->shift ?: 'N/A' }}</td>

                            {{-- Status Badge: Uses soft-colored badges for better UI contrast --}}
                            <td>
                                <span class="badge {{ $cashier->status ? 'badge-soft-success' : 'badge-soft-danger' }} rounded-pill px-3 py-2">
                                    {{ $cashier->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            {{-- Action Tools: View, Edit, and Delete (with confirmation) --}}
                            <td class="pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('cashiers.show', $cashier) }}" class="btn btn-sm btn-outline-info border-0" title="View"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('cashiers.edit', $cashier) }}" class="btn btn-sm btn-outline-primary border-0" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    
                                    {{-- Delete operation using form submission for security --}}
                                    <form action="{{ route('cashiers.destroy', $cashier) }}" method="POST" onsubmit="return confirm('Delete this cashier?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger border-0" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Empty State: Displayed when no records match the query --}}
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-cash-register fa-2x d-block mb-2 opacity-50"></i>
                                No cashiers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination: Only rendered if multiple pages of results exist --}}
        @if($cashiers->hasPages())
            <div class="p-3 border-top">
                {{ $cashiers->links() }}
            </div>
        @endif
    </div>

    <div class="clearfix"></div>
</div>
@endsection
