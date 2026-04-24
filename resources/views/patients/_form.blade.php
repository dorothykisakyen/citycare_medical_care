@php
    $bloodGroups = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
@endphp

<div class="row g-3">

    {{-- PATIENT NUMBER --}}
    <div class="col-md-4">
        <label class="form-label">Patient Number</label>
        <input type="text" name="patient_number" class="form-control"
            value="{{ old('patient_number', $patient->patient_number ?? '') }}" required>
    </div>

    {{-- FIRST NAME --}}
    <div class="col-md-4">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control"
            value="{{ old('first_name', $patient->first_name ?? '') }}" required>
    </div>

    {{-- LAST NAME --}}
    <div class="col-md-4">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control"
            value="{{ old('last_name', $patient->last_name ?? '') }}" required>
    </div>

    {{-- GENDER --}}
    <div class="col-md-4">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select" required>
            <option value="">Select Gender</option>
            @foreach(['male'=>'Male','female'=>'Female'] as $value => $label)
                <option value="{{ $value }}"
                    {{ old('gender', $patient->gender ?? '') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- DOB --}}
    <div class="col-md-4">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="date_of_birth" class="form-control"
            value="{{ old('date_of_birth', isset($patient->date_of_birth) ? $patient->date_of_birth->format('Y-m-d') : '') }}" required>
    </div>

    {{-- BLOOD GROUP --}}
    <div class="col-md-4">
        <label class="form-label">Blood Group</label>
        <select name="blood_group" class="form-select">
            <option value="">Select Blood Group</option>
            @foreach($bloodGroups as $group)
                <option value="{{ $group }}"
                    {{ old('blood_group', $patient->blood_group ?? '') == $group ? 'selected' : '' }}>
                    {{ $group }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- PHONE --}}
    <div class="col-md-4">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control"
            value="{{ old('phone', $patient->phone ?? '') }}" required>
    </div>

    {{-- EMAIL --}}
    <div class="col-md-4">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
            value="{{ old('email', $patient->email ?? '') }}">
    </div>

    {{-- 🔥 LINK EXISTING USER (ONLY WHEN EDITING) --}}
    @if(isset($patient))
        <div class="col-md-4">
            <label class="form-label">Link Login Account</label>

            <select name="user_id" class="form-select">
                <option value="">No login account</option>

                @foreach(\App\Models\User::where('role','patient')->orderBy('name')->get() as $user)
                    <option value="{{ $user->id }}"
                        {{ (string) old('user_id', $patient->user_id ?? '') === (string) $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    {{-- REGISTRATION DATE --}}
    <div class="col-md-4">
        <label class="form-label">Registration Date</label>
        <input type="date" name="registration_date" class="form-control"
            value="{{ old('registration_date', isset($patient->registration_date) ? $patient->registration_date->format('Y-m-d') : now()->format('Y-m-d')) }}">
    </div>

    {{-- EMERGENCY CONTACT NAME --}}
    <div class="col-md-6">
        <label class="form-label">Emergency Contact Name</label>
        <input type="text" name="emergency_contact_name" class="form-control"
            value="{{ old('emergency_contact_name', $patient->emergency_contact_name ?? '') }}">
    </div>

    {{-- EMERGENCY CONTACT PHONE --}}
    <div class="col-md-6">
        <label class="form-label">Emergency Contact Phone</label>
        <input type="text" name="emergency_contact_phone" class="form-control"
            value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone ?? '') }}">
    </div>

    {{-- ADDRESS --}}
    <div class="col-12">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="3">{{ old('address', $patient->address ?? '') }}</textarea>
    </div>

    {{-- STATUS --}}
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            <option value="1" {{ (string)old('status', $patient->status ?? '1') === '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ (string)old('status', $patient->status ?? '1') === '0' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    {{-- CREATE LOGIN (ONLY WHEN CREATING) --}}
    @if(!isset($patient))
        <div class="col-md-4">
            <label class="form-label">Create Patient Login?</label>
            <select name="create_login" class="form-select">
                <option value="0">No</option>
                <option value="1" {{ old('create_login') == '1' ? 'selected' : '' }}>Yes</option>
            </select>
        </div>
    @endif

    {{-- PASSWORD --}}
    <div class="col-md-4">
        <label class="form-label">
            {{ isset($patient) ? 'New Password (Optional)' : 'Password' }}
        </label>
        <input type="password" name="password" class="form-control">
    </div>

    {{-- CONFIRM PASSWORD --}}
    <div class="col-md-4">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>

</div>