<div class="row g-3">
    {{-- Appointment Link: The primary selector to link this medical note to a specific booking --}}
    {{-- Includes data attributes used by JS to auto-populate patient, doctor, and date info --}}
    <div class="col-md-12">
        <label class="form-label">Appointment</label>
        <select name="appointment_id" id="appointment_id" class="form-select" required>
            <option value="">Select Appointment</option>
            @foreach($appointments as $appointment)
                <option value="{{ $appointment->id }}" 
                    data-patient="{{ $appointment->patient_id }}" 
                    data-doctor="{{ $appointment->doctor_id }}" 
                    data-visit-date="{{ isset($appointment->appointment_date) ? $appointment->appointment_date->format('Y-m-d') : '' }}" 
                    {{ old('appointment_id', $consultation_note->appointment_id ?? '') == $appointment->id ? 'selected' : '' }}>
                    {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }} - {{ $appointment->appointment_date->format('d M Y') }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Hidden Inputs: These store the IDs of the patient and doctor linked to the selected appointment --}}
    <input type="hidden" name="patient_id" id="patient_id" value="{{ old('patient_id', $consultation_note->patient_id ?? '') }}">
    <input type="hidden" name="doctor_id" id="doctor_id" value="{{ old('doctor_id', $consultation_note->doctor_id ?? '') }}">

    {{-- Visit Date: Defaults to the appointment date but can be overridden manually --}}
    <div class="col-md-4">
        <label class="form-label">Visit Date</label>
        <input type="date" name="visit_date" id="visit_date" class="form-control" value="{{ old('visit_date', isset($consultation_note->visit_date) ? $consultation_note->visit_date->format('Y-m-d') : '') }}" required>
    </div>

    {{-- Clinical Documentation: Symptoms described by the patient --}}
    <div class="col-md-12">
        <label class="form-label">Symptoms</label>
        <textarea name="symptoms" class="form-control" rows="3">{{ old('symptoms', $consultation_note->symptoms ?? '') }}</textarea>
    </div>

    {{-- Diagnosis: The doctor's assessment of the patient's condition --}}
    <div class="col-md-12">
        <label class="form-label">Diagnosis</label>
        <textarea name="diagnosis" class="form-control" rows="3">{{ old('diagnosis', $consultation_note->diagnosis ?? '') }}</textarea>
    </div>

    {{-- Prescription: Medications or tests ordered for the patient --}}
    <div class="col-md-12">
        <label class="form-label">Prescription</label>
        <textarea name="prescription" class="form-control" rows="3">{{ old('prescription', $consultation_note->prescription ?? '') }}</textarea>
    </div>

    {{-- Treatment Notes: General remarks regarding the procedure or consultation --}}
    <div class="col-md-12">
        <label class="form-label">Treatment Notes</label>
        <textarea name="treatment_notes" class="form-control" rows="4">{{ old('treatment_notes', $consultation_note->treatment_notes ?? '') }}</textarea>
    </div>

    {{-- Follow Up: Optional date for a return visit --}}
    <div class="col-md-4">
        <label class="form-label">Follow Up Date</label>
        <input type="date" name="follow_up_date" class="form-control" value="{{ old('follow_up_date', isset($consultation_note->follow_up_date) ? $consultation_note->follow_up_date->format('Y-m-d') : '') }}">
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const appointmentSelect = document.getElementById('appointment_id');
        const patientInput = document.getElementById('patient_id');
        const doctorInput = document.getElementById('doctor_id');
        const visitDateInput = document.getElementById('visit_date');

        /**
         * Function: syncAppointmentDetails
         * Automatically pulls patient, doctor, and date data from the 
         * appointment dropdown attributes and updates the form values.
         */
        function syncAppointmentDetails() {
            const selected = appointmentSelect.options[appointmentSelect.selectedIndex];

            // Reset fields if no appointment is selected
            if (!selected || !selected.value) {
                patientInput.value = '';
                doctorInput.value = '';
                if (!visitDateInput.dataset.manual) {
                    visitDateInput.value = '';
                }
                return;
            }

            // Map data attributes to input values
            patientInput.value = selected.getAttribute('data-patient') || '';
            doctorInput.value = selected.getAttribute('data-doctor') || '';

            // Only update date if it hasn't been manually edited by the user
            if (!visitDateInput.value) {
                visitDateInput.value = selected.getAttribute('data-visit-date') || '';
            }
        }

        // Logic to track if the user has manually changed the visit date
        if (visitDateInput.value) {
            visitDateInput.dataset.manual = '1';
        }

        visitDateInput.addEventListener('change', function () {
            if (visitDateInput.value) {
                visitDateInput.dataset.manual = '1';
            }
        });

        // Trigger sync whenever the appointment changes
        appointmentSelect.addEventListener('change', syncAppointmentDetails);

        // Initial sync on page load (for edit forms or old input)
        syncAppointmentDetails();
    });
</script>
@endpush
