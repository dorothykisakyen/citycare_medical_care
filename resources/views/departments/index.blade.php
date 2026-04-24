@extends('layouts.app')

@section('title', 'Departments')

@section('content')
<div class="d-flex flex-column" style="min-height: 80vh;">
    
    {{-- Page Header: Title and primary action button for creating new departments --}}
    <div class="page-title d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Departments</h3>
            <p class="text-muted">Manage clinic departments with search, filtering, pagination, and soft deletes.</p>
        </div>
        <a href="{{ route('departments.create') }}" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-plus me-2"></i>Add Department
        </a>
    </div>

    {{-- Filter Panel: Provides search by text and status filtering to narrow down department lists --}}
    <div class="dashboard-panel mb-4 shadow-sm bg-white p-4 rounded">
        <form method="GET" action="{{ route('departments.index') }}">
            <div class="row g-3">
                {{-- Search Input: Checks against department name and description --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Search by name or description">
                </div>

                {{-- Status Filter: Dropdown to show Active, Inactive, or All departments --}}
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- Form Actions: Submit filter or reset all query parameters --}}
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button class="btn btn-primary w-100">
                        <i class="fa-solid fa-magnifying-glass me-2"></i>Filter
                    </button>
                    <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </div>
        </form>
    </div>

    {{-- Data Table Section: Displays paginated department records --}}
    <div class="dashboard-panel table-card shadow-sm mb-auto bg-white rounded overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        {{-- Row Indexing: Adjusted to account for current pagination page --}}
                        <th class="ps-4">#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th width="150" class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $department)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration + ($departments->firstItem() - 1) }}</td>
                            <td class="fw-bold text-primary">{{ $department->name }}</td>
                            
                            {{-- Truncated Description: Prevents long text from breaking the table layout --}}
                            <td>{{ \Illuminate\Support\Str::limit($department->description, 50) ?: 'N/A' }}</td>

                            {{-- Status Badge: Uses soft-color classes for modern UI aesthetic --}}
                            <td>
                                <span class="badge {{ $department->status ? 'badge-soft-success' : 'badge-soft-danger' }} rounded-pill px-3 py-2">
                                    {{ $department->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            {{-- CRUD Action Icons --}}
                            <td class="pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    {{-- View Details --}}
                                    <a href="{{ route('departments.show', $department) }}" class="btn btn-sm btn-outline-info border-0" title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    {{-- Edit Record --}}
                                    <a href="{{ route('departments.edit', $department) }}" class="btn btn-sm btn-outline-primary border-0" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    {{-- Delete with confirmation prompt --}}
                                    <form action="{{ route('departments.destroy', $department) }}" method="POST" onsubmit="return confirm('Delete this department?');" class="d-inline">
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
                        {{-- Empty State Placeholder --}}
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-building-circle-exclamation fa-2x d-block mb-2 opacity-50"></i>
                                No departments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links: Displays only if the result set is larger than the per-page limit --}}
        @if($departments->hasPages())
            <div class="p-3 border-top">
                {{ $departments->links() }}
            </div>
        @endif
    </div>

    <div class="clearfix"></div>
</div>
@endsection
