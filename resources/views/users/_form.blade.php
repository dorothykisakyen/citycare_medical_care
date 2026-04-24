<div class="row g-3">
    {{-- Personal Information: Basic contact details for the system user --}}
    <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
    </div>

    {{-- Email Address: Used as the primary login identifier --}}
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
    </div>

    {{-- Contact Number: Optional field for user communication --}}
    <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
    </div>

    {{-- System Access Level: Determines which dashboard and permissions the user can access --}}
    <div class="col-md-6">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
            <option value="">Select Role</option>
            @foreach(['admin'=>'Admin','receptionist'=>'Receptionist','doctor'=>'Doctor','cashier'=>'Cashier','patient'=>'Patient'] as $value => $label)
                <option value="{{ $value }}" {{ old('role', $user->role ?? '') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Account Status: Toggle to enable (Active) or disable (Inactive) account access immediately --}}
    <div class="col-md-6">
        <label class="form-label">Account Status</label>
        <select name="is_active" class="form-select" required>
            <option value="1" {{ (string) old('is_active', $user->is_active ?? '1') === '1' ? 'selected' : '' }}>
                Active
            </option>
            <option value="0" {{ (string) old('is_active', $user->is_active ?? '1') === '0' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>

    <div class="col-md-6"></div> {{-- Spacer for layout alignment --}}

    {{-- Security Credentials: Required on account creation, optional during profile updates --}}
    <div class="col-md-6">
        <label class="form-label">{{ isset($user) ? 'New Password' : 'Password' }}</label>
        <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" {{ isset($user) ? '' : 'required' }}>
    </div>
</div>
