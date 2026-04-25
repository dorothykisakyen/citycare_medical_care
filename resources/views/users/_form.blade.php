<div class="row g-3">

    {{-- Full Name --}}
    <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ old('name', $user->name ?? '') }}"
            required>
    </div>

    {{-- Email --}}
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old('email', $user->email ?? '') }}"
            required>
    </div>

    {{-- Phone --}}
    <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input
            type="text"
            name="phone"
            class="form-control"
            value="{{ old('phone', $user->phone ?? '') }}">
    </div>

    {{-- Role --}}
    <div class="col-md-6">
        <label class="form-label">Role</label>
        <select
            name="role"
            id="role"
            class="form-select"
            required>
            <option value="">Select Role</option>

            @foreach([
                'admin' => 'Admin',
                'receptionist' => 'Receptionist',
                'doctor' => 'Doctor',
                'cashier' => 'Cashier',
                'patient' => 'Patient'
            ] as $value => $label)

                <option
                    value="{{ $value }}"
                    {{ old('role', $user->role ?? '') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>

            @endforeach
        </select>
    </div>

    {{-- Doctor Fields --}}
    <div id="doctorFields" style="display: none;">

        <div class="row g-3">

            {{-- Department --}}
            <div class="col-md-6">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select">
                    <option value="">Select Department</option>

                    @foreach(\App\Models\Department::where('status', 1)->orderBy('name')->get() as $department)
                        <option
                            value="{{ $department->id }}"
                            {{ old('department_id') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Specialization --}}
            <div class="col-md-6">
                <label class="form-label">Specialization</label>
                <input
                    type="text"
                    name="specialization"
                    class="form-control"
                    value="{{ old('specialization') }}"
                    placeholder="e.g Cardiology">
            </div>

        </div>
    </div>

    {{-- Account Status --}}
    <div class="col-md-6">
        <label class="form-label">Account Status</label>
        <select name="is_active" class="form-select" required>
            <option
                value="1"
                {{ (string) old('is_active', $user->is_active ?? '1') === '1' ? 'selected' : '' }}>
                Active
            </option>

            <option
                value="0"
                {{ (string) old('is_active', $user->is_active ?? '1') === '0' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>

    <div class="col-md-6"></div>

    {{-- Password --}}
    <div class="col-md-6">
        <label class="form-label">
            {{ isset($user) ? 'New Password' : 'Password' }}
        </label>

        <input
            type="password"
            name="password"
            class="form-control"
            {{ isset($user) ? '' : 'required' }}>
    </div>

    {{-- Confirm Password --}}
    <div class="col-md-6">
        <label class="form-label">Confirm Password</label>

        <input
            type="password"
            name="password_confirmation"
            class="form-control"
            {{ isset($user) ? '' : 'required' }}>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const roleSelect = document.getElementById("role");
    const doctorFields = document.getElementById("doctorFields");

    function toggleDoctorFields() {
        if (roleSelect.value === "doctor") {
            doctorFields.style.display = "block";
        } else {
            doctorFields.style.display = "none";
        }
    }

    toggleDoctorFields();

    roleSelect.addEventListener("change", toggleDoctorFields);
});
</script>
@endpush