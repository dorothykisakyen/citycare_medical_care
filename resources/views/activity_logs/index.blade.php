@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
<div class="d-flex flex-column" style="min-height: 80vh;">
    
    {{-- Page Header: Title and short description --}}
    <div class="page-title mb-4">
        <h3>Activity Logs</h3>
        <p class="text-muted">Track important system actions performed by users.</p>
    </div>

    {{-- Filter Section: Search bar for filtering logs by various parameters --}}
    <div class="dashboard-panel mb-4 shadow-sm bg-white p-4 rounded">
        <form method="GET" action="{{ route('activity_logs.index') }}">
            <div class="row g-3">
                <div class="col-md-10">
                    <label class="form-label fw-semibold">Search Logs</label>
                    <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Search by action, module, user, or description...">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="fa-solid fa-magnifying-glass me-2"></i>Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Main Content: Table showing the list of system activity --}}
    <div class="dashboard-panel table-card shadow-sm mb-auto bg-white rounded overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">User</th>
                        <th>Action</th>
                        <th>Module</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th class="pe-4">Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            {{-- User Column: Shows avatar icon and user name (or 'System' if null) --}}
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                        <i class="fa-solid fa-user text-muted small"></i>
                                    </div>
                                    <span class="fw-medium">{{ $log->user?->name ?? 'System' }}</span>
                                </div>
                            </td>

                            {{-- Action Column: Dynamic badge colors based on action type (Create/Update/Delete) --}}
                            <td>
                                @php
                                    $actionClass = match($log->action) {
                                        'create' => 'bg-success-subtle text-success',
                                        'update' => 'bg-primary-subtle text-primary',
                                        'delete' => 'bg-danger-subtle text-danger',
                                        default  => 'bg-secondary-subtle text-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $actionClass }} text-capitalize px-2 py-1">
                                    {{ $log->action }}
                                </span>
                            </td>

                            {{-- Module Column: Formats the module name (e.g., patient_records -> Patient records) --}}
                            <td><span class="text-muted">{{ ucfirst(str_replace('_', ' ', $log->module)) }}</span></td>

                            {{-- Description Column: Short text explaining what exactly happened --}}
                            <td><small class="text-dark">{{ $log->description }}</small></td>

                            {{-- Network Info: IP address of the device that performed the action --}}
                            <td><code class="small text-muted">{{ $log->ip_address }}</code></td>

                            {{-- Timestamp: Formatted date and time --}}
                            <td class="pe-4 text-nowrap">
                                <span class="small">{{ $log->created_at->format('d M Y') }}</span><br>
                                <span class="text-muted smallest">{{ $log->created_at->format('H:i:s') }}</span>
                            </td>
                        </tr>
                    @empty
                        {{-- Empty State: Displayed when no logs match the search or the table is empty --}}
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-clock-rotate-left fa-2x d-block mb-2 opacity-50"></i>
                                No activity logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links: Displayed only if there are multiple pages of logs --}}
        @if($logs->hasPages())
            <div class="p-3 border-top">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    <div class="clearfix"></div>
</div>
@endsection
