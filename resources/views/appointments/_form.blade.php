<div class="row g-3">
    {{-- Patient Selection: The primary dropdown that stores the selected patient ID --}}
    <div class="col-md-6">
        <label class="form-label">Patient</label>
        <select name="patient_id" id="patient_id" class="form-select" required>
            <option value="">Select Patient</option>
            @foreach($patients as $patientOption)
                <option value="{{ $patientOption->id }}" {{ (string)old('patient_id', $appointment->patient_id ?? '') === (string)$patientOption->id ? 'selected' : '' }}>
                    {{ $patientOption->patient_number }} - {{ $patientOption->first_name }} {{ $patientOption->last_name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Instant Search: Helper field for users to quickly find a patient without scrolling the dropdown --}}
    <div class="col-md-6">
        <label class="form-label">Instant Patient Search</label>
        <input type="text" id="patientSearch" class="form-control" placeholder="Type patient name, phone, or number">
        <div id="patientSearchResults" class="list-group mt-2"></div>
    </div>

    {{-- Doctor Selection: Includes a data-department attribute for JS-based filtering --}}
    <div class="col-md-4">
        <label class="form-label">Doctor</label>
        <select name="doctor_id" id="doctor_id" class="form-select" required>
            <option value="">Select Doctor</option>
            @foreach($doctors as $doctorOption)
                <option value="{{ $doctorOption->id }}" data-department="{{ $doctorOption->department_id }}" {{ (string)old('doctor_id', $appointment->doctor_id ?? '') === (string)$doctorOption->id ? 'selected' : '' }}>
                    {{ $doctorOption->first_name }} {{ $doctorOption->last_name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Department Selection: Must align with the selected doctor's specialization --}}
    <div class="col-md-4">
        <label class="form-label">Department</label>
        <select name="department_id" id="department_id" class="form-select" required>
            <option value="">Select Department</option>
            @foreach($departments as $departmentOption)
                <option value="{{ $departmentOption->id }}" {{ (string)old('department_id', $appointment->department_id ?? '') === (string)$departmentOption->id ? 'selected' : '' }}>
                    {{ $departmentOption->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Appointment Date: Handles formatting for both existing records and new old-input --}}
    <div class="col-md-4">
        <label class="form-label">Appointment Date</label>
        <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="{{ old('appointment_date', isset($appointment->appointment_date) ? $appointment->appointment_date->format('Y-m-d') : '') }}" required>
    </div>

    {{-- Time Slots: Standard Start and End times --}}
    <div class="col-md-3">
        <label class="form-label">Start Time</label>
        <input type="time" name="appointment_time" id="appointment_time" class="form-control" value="{{ old('appointment_time', isset($appointment->appointment_time) ? substr($appointment->appointment_time,0,5) : '') }}" required>
    </div>

    <div class="col-md-3">
        <label class="form-label">End Time</label>
        <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', isset($appointment->end_time) ? substr($appointment->end_time,0,5) : '') }}" required>
    </div>

    {{-- Reason: Short summary of the medical visit --}}
    <div class="col-md-6">
        <label class="form-label">Reason</label>
        <input type="text" name="reason" class="form-control" value="{{ old('reason', $appointment->reason ?? '') }}" required>
    </div>

    {{-- Status: Workflow control (Defaults to 'pending' for new appointments) --}}
    <div class="col-md-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            @foreach(['pending','confirmed','completed','cancelled'] as $statusItem)
                <option value="{{ $statusItem }}" {{ old('status', $appointment->status ?? 'pending') === $statusItem ? 'selected' : '' }}>{{ ucfirst($statusItem) }}</option>
            @endforeach
        </select>
    </div>

    {{-- Cancellation Reason: Only applicable if the status is set to 'cancelled' --}}
    <div class="col-md-3">
        <label class="form-label">Cancellation Reason</label>
        <input type="text" name="cancellation_reason" class="form-control" value="{{ old('cancellation_reason', $appointment->cancellation_reason ?? '') }}">
    </div>

    {{-- Additional Notes: Multi-line text for detailed clinical or admin information --}}
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $appointment->notes ?? '') }}</textarea>
    </div>
</div>
