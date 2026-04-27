<div class="row g-3">

    {{-- Auto Generated Doctor Number --}}
    <div class="col-md-4">
        <label class="form-label">Doctor Number</label>
        <input
            type="text"
            name="doctor_number"
            class="form-control"
            value="{{ old('doctor_number', $doctor->doctor_number ?? 'Auto Generated') }}"
            readonly>
    </div>

    {{-- First Name --}}
    <div class="col-md-4">
        <label class="form-label">First Name</label>
        <input
            type="text"
            name="first_name"
            class="form-control"
            value="{{ old('first_name', $doctor->first_name ?? '') }}"
            required>
    </div>

    {{-- Last Name --}}
    <div class="col-md-4">
        <label class="form-label">Last Name</label>
        <input
            type="text"
            name="last_name"
            class="form-control"
            value="{{ old('last_name', $doctor->last_name ?? '') }}"
            required>
    </div>

    {{-- Gender --}}
    <div class="col-md-4">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select" required>
            <option value="">Select Gender</option>

            <option value="male"
                {{ old('gender', $doctor->gender ?? '') == 'male' ? 'selected' : '' }}>
                Male
            </option>

            <option value="female"
                {{ old('gender', $doctor->gender ?? '') == 'female' ? 'selected' : '' }}>
                Female
            </option>
        </select>
    </div>

    {{-- Department --}}
    <div class="col-md-4">
        <label class="form-label">Department</label>
        <select name="department_id" class="form-select" required>
            <option value="">Select Department</option>

            @foreach($departments as $department)
                <option
                    value="{{ $department->id }}"
                    {{ old('department_id', $doctor->department_id ?? '') == $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Specialization --}}
    <div class="col-md-4">
        <label class="form-label">Specialization</label>
        <input
            type="text"
            name="specialization"
            class="form-control"
            value="{{ old('specialization', $doctor->specialization ?? '') }}">
    </div>

    {{-- Phone --}}
    <div class="col-md-4">
        <label class="form-label">Phone</label>
        <input
            type="text"
            name="phone"
            class="form-control"
            value="{{ old('phone', $doctor->phone ?? '') }}"
            required>
    </div>

    {{-- Email --}}
    <div class="col-md-4">
        <label class="form-label">Email</label>
        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old('email', $doctor->email ?? '') }}"
            required>
    </div>

    {{-- Consultation Fee --}}
    <div class="col-md-4">
        <label class="form-label">Consultation Fee</label>
        <input
            type="number"
            step="0.01"
            name="consultation_fee"
            class="form-control"
            value="{{ old('consultation_fee', $doctor->consultation_fee ?? '') }}">
    </div>

    {{-- Room Number --}}
    <div class="col-md-4">
        <label class="form-label">Room Number</label>
        <input
            type="text"
            name="room_number"
            class="form-control"
            value="{{ old('room_number', $doctor->room_number ?? '') }}">
    </div>

    {{-- Hire Date --}}
    <div class="col-md-4">
        <label class="form-label">Hire Date</label>
        <input
            type="date"
            name="hire_date"
            class="form-control"
            value="{{ old('hire_date', isset($doctor->hire_date) ? $doctor->hire_date->format('Y-m-d') : '') }}">
    </div>

    {{-- Status --}}
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="1"
                {{ old('status', $doctor->status ?? '1') == '1' ? 'selected' : '' }}>
                Active
            </option>

            <option value="0"
                {{ old('status', $doctor->status ?? '1') == '0' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>

</div>