@extends('layouts.app')

@section('content')
<div class="page-title">
    <h3>Book Appointment</h3>
    <p>Create a new appointment and prevent overlapping doctor slots.</p>
</div>

<div class="dashboard-panel">
    {{-- Appointment Creation Form --}}
    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf
        {{-- Reusable form fields (includes patient, doctor, and time inputs) --}}
        @include('appointments._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Save Appointment</button>
            <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // DOM Element Selectors
    const doctorSelect = document.getElementById('doctor_id');
    const dateInput = document.getElementById('appointment_date');
    const slotSelect = document.getElementById('slot_select');
    const startInput = document.getElementById('appointment_time');
    const endInput = document.getElementById('end_time');
    const departmentSelect = document.getElementById('department_id');
    const patientSearch = document.getElementById('patientSearch');
    const patientResults = document.getElementById('patientSearchResults');
    const patientSelect = document.getElementById('patient_id');

    /**
     * Event: Doctor Selection Change
     * 1. Automatically updates the Department dropdown based on doctor data
     * 2. Triggers the slot loader to show available times
     */
    doctorSelect?.addEventListener('change', () => {
        const selected = doctorSelect.options[doctorSelect.selectedIndex];
        if (selected?.dataset?.department) {
            departmentSelect.value = selected.dataset.department;
        }
        loadSlots();
    });

    // Refresh slots whenever the appointment date is changed
    dateInput?.addEventListener('change', loadSlots);

    /**
     * Event: Slot Selection Change
     * When a user picks a pre-defined time slot, split the value 
     * and fill the hidden/visible Start and End time inputs.
     */
    slotSelect?.addEventListener('change', () => {
        const value = slotSelect.value;
        if (!value) return;
        const [start, end] = value.split('|');
        startInput.value = start;
        endInput.value = end;
    });

    /**
     * Function: loadSlots
     * Fetches available time slots for a specific doctor on a specific date 
     * via an AJAX call to prevent overlapping bookings.
     */
    async function loadSlots() {
        if (!doctorSelect.value || !dateInput.value) return;

        slotSelect.innerHTML = '<option>Loading...</option>';
        
        const response = await fetch(`/ajax/doctors/${doctorSelect.value}/available-slots?date=${dateInput.value}`);
        const data = await response.json();
        
        slotSelect.innerHTML = '<option value="">Choose available slot</option>';

        if (!data.length) {
            slotSelect.innerHTML += '<option value="">No available slots</option>';
            return;
        }

        // Populate dropdown with fetched slot data
        data.forEach(slot => {
            const option = document.createElement('option');
            option.value = `${slot.start}|${slot.end}`;
            option.textContent = slot.label;
            slotSelect.appendChild(option);
        });
    }

    /**
     * AJAX Patient Search Logic
     * Uses a "debounce" timer (300ms) to avoid hitting the server 
     * on every single keystroke.
     */
    let patientSearchTimer;
    patientSearch?.addEventListener('input', () => {
        clearTimeout(patientSearchTimer);
        const q = patientSearch.value.trim();

        patientSearchTimer = setTimeout(async () => {
            if (!q) {
                patientResults.innerHTML = '';
                return;
            }

            const response = await fetch(`/ajax/patients/search?q=${encodeURIComponent(q)}`);
            const data = await response.json();
            
            patientResults.innerHTML = '';

            // Render search results as clickable buttons
            data.forEach(item => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'list-group-item list-group-item-action';
                button.textContent = item.text;
                
                // When a patient is clicked, update the actual hidden select and clear results
                button.onclick = () => {
                    patientSelect.value = item.id;
                    patientSearch.value = item.text;
                    patientResults.innerHTML = '';
                };
                patientResults.appendChild(button);
            });
        }, 300);
    });
</script>
@endpush
