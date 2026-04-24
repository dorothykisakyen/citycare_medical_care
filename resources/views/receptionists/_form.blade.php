<div class="row g-3">
    {{-- Unique Staff ID: Stores the official receptionist employee number --}}
    <div class="col-md-4">
        <label class="form-label">Receptionist Number</label>
        <input type="text" name="receptionist_number" class="form-control" value="{{ old('receptionist_number', $receptionist->receptionist_number ?? '') }}" required>
    </div>

    {{-- Personal Identification: Basic name fields for the staff member --}}
    <div class="col-md-4">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $receptionist->first_name ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $receptionist->last_name ?? '') }}" required>
    </div>

    {{-- Demographic Information: Selection for gender categorization --}}
    <div class="col-md-4">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select">
            <option value="">Select Gender</option>
            <option value="male" {{ old('gender', $receptionist->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender', $receptionist->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ old('gender', $receptionist->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>

    {{-- Contact Information: Essential for system notifications and account management --}}
    <div class="col-md-4">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $receptionist->phone ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $receptionist->email ?? '') }}" required>
    </div>

    {{-- Work Details: Shift schedules and the date of joining the medical centre --}}
    <div class="col-md-4">
        <label class="form-label">Shift</label>
        <input type="text" name="shift" class="form-control" value="{{ old('shift', $receptionist->shift ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Hire Date</label>
        <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', isset($receptionist->hire_date) ? $receptionist->hire_date->format('Y-m-d') : '') }}">
    </div>

    {{-- Account Status: Toggle to enable (Active) or disable (Inactive) system access --}}
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="1" {{ (string)old('status', $receptionist->status ?? '1') === '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ (string)old('status', $receptionist->status ?? '1') === '0' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    {{-- Location: Multi-line text for physical residence details --}}
    <div class="col-12">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="3">{{ old('address', $receptionist->address ?? '') }}</textarea>
    </div>

    {{-- Security Credentials: Password fields. Required on creation, optional on edit/update --}}
    <div class="col-md-6">
        <label class="form-label">{{ isset($receptionist) ? 'New Password' : 'Password' }}</label>
        <input type="password" name="password" class="form-control" {{ isset($receptionist) ? '' : 'required' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" {{ isset($receptionist) ? '' : 'required' }}>
    </div>
</div>
