@extends('layouts.app')

@section('title', 'System Admins')

@section('content')
<div class="d-flex flex-column" style="min-height: 80vh;">
    
    {{-- Page Header: Title and Action Button to create new Admins --}}
    <div class="page-title d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Admins</h3>
            <p class="text-muted">Manage administrator accounts and system supervisors.</p>
        </div>
        <a href="{{ route('admins.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>Add Admin
        </a>
    </div>

    {{-- Filter Section: Search bar and Status dropdown for refining the admin list --}}
    <div class="dashboard-panel mb-4 shadow-sm">
        <form method="GET" action="{{ route('admins.index') }}">
            <div class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Search by name, email or admin number...">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="1" {{ $status === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $status === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Main Content: Table containing the list of registered administrators --}}
    <div class="dashboard-panel table-card shadow-sm mb-auto">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Admin No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Job Title</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr>
                            {{-- Admin Identification --}}
                            <td class="fw-bold text-primary">{{ $admin->admin_number }}</td>
                            <td>{{ $admin->first_name }} {{ $admin->last_name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->job_title }}</td>

                            {{-- Status Badge: Green for Active (1), Red for Inactive (0) --}}
                            <td>
                                <span class="badge {{ $admin->status ? 'badge-soft-success' : 'badge-soft-danger' }} rounded-pill px-3 py-2">
                                    {{ $admin->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            {{-- Action Buttons: View, Edit, and Delete --}}
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- View Details --}}
                                    <a href="{{ route('admins.show', $admin) }}" class="btn btn-sm btn-outline-info border-0">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    {{-- Edit Admin Info --}}
                                    <a href="{{ route('admins.edit', $admin) }}" class="btn btn-sm btn-outline-primary border-0">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    {{-- Delete Admin with Confirmation --}}
                                    <form action="{{ route('admins.destroy', $admin) }}" method="POST" onsubmit="return confirm('Delete this admin?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger border-0">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Empty State: Displayed when no administrators match the filters --}}
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-user-shield fa-2x d-block mb-2 opacity-50"></i>
                                No admins found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination: Displayed only if results span multiple pages --}}
        @if($admins->hasPages())
            <div class="p-3 border-top">
                {{ $admins->links() }}
            </div>
        @endif
    </div>

    <div class="clearfix"></div>
</div>
@endsection
