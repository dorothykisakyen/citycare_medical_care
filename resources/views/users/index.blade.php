@extends('layouts.app')

@section('title', 'Users')

@section('content')
{{-- 1. PAGE HEADER: Title and primary action button (Add User) --}}
<div class="page-title d-flex justify-content-between align-items-center mb-4">
    <div>
        {{-- Dynamic title based on filtered role --}}
        <h3 class="fw-bold text-dark">
            @if($role) {{ ucfirst($role) }} Users @else Users @endif
        </h3>
        <p class="text-muted mb-0">Manage system users, roles, and account access.</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
        <i class="fa-solid fa-plus me-2"></i>Add User
    </a>
</div>

{{-- 2. FILTER SECTION: Search and Role filtering tools --}}
<div class="dashboard-panel mb-4 shadow-sm bg-white p-4 rounded">
    <form method="GET" action="{{ route('users.index') }}">
        <div class="row g-3 align-items-end">
            {{-- Search Input: Checks Name, Email, Phone, etc. --}}
            <div class="col-md-5">
                <label class="form-label fw-semibold">Search Users</label>
                <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Search name, email, phone or role...">
            </div>

            {{-- Role Dropdown: Filters list by specific system permissions --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Role</label>
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    @foreach(['admin'=>'Admin','receptionist'=>'Receptionist','doctor'=>'Doctor','cashier'=>'Cashier','patient'=>'Patient'] as $value => $label)
                        <option value="{{ $value }}" {{ $role === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Actions: Submit and Reset buttons --}}
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-primary w-100">
                    <i class="fa-solid fa-filter me-2"></i>Filter
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </div>
    </form>
</div>

{{-- 3. DATA TABLE: Main list of user accounts --}}
<div class="dashboard-panel table-card shadow-sm bg-white rounded overflow-hidden">
    <div class="table-responsive">
        {{-- .table-hover adds a subtle background to rows on hover for better scannability --}}
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th width="120" class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        {{-- User Information --}}
                        <td class="ps-4">
                            <span class="fw-bold text-dark d-block">{{ $user->name }}</span>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td><span class="text-muted">{{ $user->phone ?? 'N/A' }}</span></td>

                        {{-- Role Badge: Primary colored badge for quick role identification --}}
                        <td>
                            <span class="badge bg-primary-subtle text-primary text-capitalize px-3 py-2 rounded-pill">
                                {{ $user->role }}
                            </span>
                        </td>

                        {{-- Status Badge: Green for Active, Red for Inactive --}}
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Active</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">Inactive</span>
                            @endif
                        </td>

                        {{-- CRUD Actions: Edit and Delete --}}
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary border-0" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                {{-- Delete Form: Uses standard Laravel method spoofing with JS confirmation --}}
                                <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?');" class="m-0">
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
                    {{-- Empty State: Displayed when no records match the criteria --}}
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fa-solid fa-users-slash fa-2x d-block mb-3 opacity-25"></i>
                            No users found matching your criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 4. PAGINATION: Displayed only if results span multiple pages --}}
    @if($users->hasPages())
        <div class="p-3 border-top bg-light">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
