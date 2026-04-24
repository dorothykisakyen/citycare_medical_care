@extends('layouts.app')

@section('title', 'Consultation Notes')

@section('content')
<div class="d-flex flex-column" style="min-height: 80vh;">
    
    {{-- Page Header: Displays main title and a quick link to record a new medical note --}}
    <div class="page-title d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Consultation Notes</h3>
            <p class="text-muted">Record diagnoses, prescriptions, and treatment history.</p>
        </div>
        <a href="{{ route('consultation_notes.create') }}" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-plus me-2"></i>Add Note
        </a>
    </div>

    {{-- Filter Panel: Enables searching through clinical history by keywords or patient names --}}
    <div class="dashboard-panel mb-4 shadow-sm bg-white p-4 rounded">
        <form method="GET" action="{{ route('consultation_notes.index') }}">
            <div class="row g-3">
                <div class="col-md-10">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="Search by diagnosis, prescription, or patient name...">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="fa-solid fa-magnifying-glass me-2"></i>Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Data Table: Summary of medical consultations, featuring truncated text for clinical assessments --}}
    <div class="dashboard-panel table-card shadow-sm mb-auto bg-white rounded overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Patient</th>
                        <th>Doctor</th>
                        <th>Diagnosis</th>
                        <th>Follow Up</th>
                        <th width="150" class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultationNotes as $note)
                        <tr>
                            {{-- Identification: Linked patient and attending doctor --}}
                            <td class="ps-4 fw-bold text-dark">
                                {{ $note->patient->first_name }} {{ $note->patient->last_name }}
                            </td>
                            <td>Dr. {{ $note->doctor->first_name }} {{ $note->doctor->last_name }}</td>
                            
                            {{-- Diagnosis: Text is limited to 40 characters for clean UI layout --}}
                            <td>
                                <span title="{{ $note->diagnosis }}">
                                    {{ \Illuminate\Support\Str::limit($note->diagnosis, 40) ?: 'N/A' }}
                                </span>
                            </td>

                            {{-- Temporal Info: Highlights the next scheduled visit date --}}
                            <td>
                                @if($note->follow_up_date)
                                    <span class="text-primary fw-medium">
                                        {{ $note->follow_up_date->format('d M Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>

                            {{-- CRUD Actions: Quick access to view, edit, or delete the record --}}
                            <td class="pe-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('consultation_notes.show', $note) }}" class="btn btn-sm btn-outline-info border-0" title="View"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('consultation_notes.edit', $note) }}" class="btn btn-sm btn-outline-primary border-0" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    
                                    {{-- Secure Delete: Includes an inline JavaScript confirmation prompt --}}
                                    <form action="{{ route('consultation_notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Delete this consultation note?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger border-0" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Placeholder: Displayed when no records match the criteria --}}
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-file-medical fa-2x d-block mb-2 opacity-50"></i>
                                No consultation notes found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination: Facilitates navigation through large datasets --}}
        @if($consultationNotes->hasPages())
            <div class="p-3 border-top">
                {{ $consultationNotes->links() }}
            </div>
        @endif
    </div>

    <div class="clearfix"></div>
</div>
@endsection
