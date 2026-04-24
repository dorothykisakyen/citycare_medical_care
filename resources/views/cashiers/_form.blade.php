<div class="row g-3">
    {{-- Unique Identification: Stores the staff ID number for the cashier --}}
    <div class="col-md-4">
        <label class="form-label">Cashier Number</label>
        <input type="text" name="cashier_number" class="form-control" value="{{ old('cashier_number', $cashier->cashier_number ?? '') }}" required>
    </div>

    {{-- Personal Details: Basic name information --}}
    <div class="col-md-4">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $cashier->first_name ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $cashier->last_name ?? '') }}" required>
    </div>

    {{-- Demographic Information: Selection for gender --}}
    <div class="col-md-4">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select">
            <option value="">Select Gender</option>
            <option value="male" {{ old('gender', $cashier->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender', $cashier->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ old('gender', $cashier->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>

    {{-- Contact Information: Essential for communication and account recovery --}}
    <div class="col-md-4">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $cashier->phone ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $cashier->email ?? '') }}" required>
    </div>

    {{-- Employment Details: Tracking shifts, start dates, and account status --}}
    <div class="col-md-4">
        <label class="form-label">Shift</label>
        <input type="text" name="shift" class="form-control" value="{{ old('shift', $cashier->shift ?? '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Hire Date</label>
        <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', isset($cashier->hire_date) ? $cashier->hire_date->format('Y-m-d') : '') }}">
    </div>

    {{-- Account Status: Toggle for access control (Active/Inactive) --}}
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="1" {{ (string)old('status', $cashier->status ?? '1') === '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ (string)old('status', $cashier->status ?? '1') === '0' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    {{-- Address Detail: Multi-line text for physical location --}}
    <div class="col-12">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="3">{{ old('address', $cashier->address ?? '') }}</textarea>
    </div>

    {{-- Security Credentials: Required on creation, optional on update --}}
    <div class="col-md-6">
        <label class="form-label">{{ isset($cashier) ? 'New Password' : 'Password' }}</label>
        <input type="password" name="password" class="form-control" {{ isset($cashier) ? '' : 'required' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" {{ isset($cashier) ? '' : 'required' }}>
    </div>
</div>
