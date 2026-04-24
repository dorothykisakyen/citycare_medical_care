<div class="row g-3">
    {{-- Unique Identification: Read-only field for the doctor's system-generated ID --}}
    <div class="col-md-4">
        <label class="form-label">Doctor Number</label>
        <input type="text" name="doctor_number" class="form-control" value="{{ old('doctor_number', $doctor->doctor_number ?? 'Auto Generated') }}" readonly>
    </div>

    {{-- Personal Details: Captures the primary name of the medical professional --}}
    <div class="col-md-4">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $doctor->first_name ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $doctor->last_name ?? '') }}" required>
    </div>

    {{-- Demographic Information: Selection for gender --}}
    <div class="col-md-4">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select" required>
            <option value="">Select Gender</option>
            @foreach(['male' => 'Male', 'female' => 'Female'] as $value => $label)
                <option value="{{ $value }}" {{ old('gender', $doctor->gender ?? '') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Professional Categorization: Links the doctor to a clinic department --}}
    <div class="col-md-4">
        <label class="form-label">Department</label>
        <select name="department_id" class="form-select" required>
            <option value="">Select Department</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ (string) old('department_id', $doctor->department_id ?? '') === (string) $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Clinical Specialty: Specific field of medicine (e.g., Cardiology, Surgery) --}}
    <div class="col-md-4">
        <label class="form-label">Specialization</label>
        <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $doctor->specialization ?? '') }}">
    </div>

    {{-- Contact Information: Essential for system notifications and account management --}}
    <div class="col-md-4">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $doctor->phone ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->email ?? '') }}" required>
    </div>

    {{-- Billing Details: The standard cost per consultation for this specific doctor --}}
    <div class="col-md-4">
        <label class="form-label">Consultation Fee</label>
        <input type="number" step="0.01" name="consultation_fee" class="form-control" value="{{ old('consultation_fee', $doctor->consultation_fee ?? '') }}">
    </div>

    {{-- Administrative Logistics: Room allocation and employment history --}}
    <div class="col-md-4">
        <label class="form-label">Room Number</label>
        <input type="text" name="room_number" class="form-control" value="{{ old('room_number', $doctor->room_number ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Hire Date</label>
        <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', isset($doctor->hire_date) ? $doctor->hire_date->format('Y-m-d') : '') }}">
    </div>

    {{-- Availability Status: Toggles the doctor's active presence in the system --}}
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="1" {{ (string) old('status', $doctor->status ?? '1') === '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ (string) old('status', $doctor->status ?? '1') === '0' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    {{-- Login Management: Conditional field for creating a linked user account on registration --}}
    @if(!isset($doctor))
    <div class="col-md-4">
        <label class="form-label">Create Doctor Login?</label>
        <select name="create_login" class="form-select">
            <option value="0">No</option>
            <option value="1" {{ old('create_login') == '1' ? 'selected' : '' }}>Yes</option>
        </select>
    </div>
    @endif

    {{-- Security Credentials: Password fields (Required on create, optional on update) --}}
    <div class="col-md-4">
        <label class="form-label">{{ isset($doctor) ? 'New Password' : 'Password' }}</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
</div>
