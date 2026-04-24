<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Admin Number</label>
        <input type="text" name="admin_number" class="form-control" value="{{ old('admin_number', $admin->admin_number ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $admin->first_name ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $admin->last_name ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select">
            <option value="">Select Gender</option>
            <option value="male" {{ old('gender', $admin->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender', $admin->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
            <option value="other" {{ old('gender', $admin->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $admin->phone ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Job Title</label>
        <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $admin->job_title ?? 'System Administrator') }}" required>
    </div>

    <div class="col-md-4">
        <label class="form-label">Hire Date</label>
        <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', isset($admin->hire_date) ? $admin->hire_date->format('Y-m-d') : '') }}">
    </div>

    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="1" {{ (string)old('status', $admin->status ?? '1') === '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ (string)old('status', $admin->status ?? '1') === '0' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <div class="col-12">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="3">{{ old('address', $admin->address ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">{{ isset($admin) ? 'New Password' : 'Password' }}</label>
        <input type="password" name="password" class="form-control" {{ isset($admin) ? '' : 'required' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" {{ isset($admin) ? '' : 'required' }}>
    </div>
</div>