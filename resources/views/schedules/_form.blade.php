<div class="row g-3">
    {{-- Doctor Selection: Links the schedule to a specific medical professional and their department --}}
    <div class="col-md-4">
        <label class="form-label">Doctor</label>
        <select name="doctor_id" class="form-select" required>
            <option value="">Select Doctor</option>
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}" {{ (string) old('doctor_id', $schedule->doctor_id ?? '') === (string) $doctor->id ? 'selected' : '' }}>
                    {{ $doctor->first_name }} {{ $doctor->last_name }} - {{ $doctor->department->name ?? 'N/A' }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Workday Definition: Specifies which day of the week this time configuration applies to --}}
    <div class="col-md-4">
        <label class="form-label">Day of Week</label>
        <select name="day_of_week" class="form-select" required>
            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $dayName)
                <option value="{{ $dayName }}" {{ old('day_of_week', $schedule->day_of_week ?? '') === $dayName ? 'selected' : '' }}>
                    {{ $dayName }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Appointment Interval: Defines the length of each patient consultation block (default is 30 mins) --}}
    <div class="col-md-4">
        <label class="form-label">Slot Duration (minutes)</label>
        <input type="number" name="slot_duration" min="5" max="180" class="form-control" value="{{ old('slot_duration', $schedule->slot_duration ?? 30) }}" required>
    </div>

    {{-- Shift Start: The time the doctor begins seeing patients on this day --}}
    <div class="col-md-4">
        <label class="form-label">Start Time</label>
        <input type="time" name="start_time" class="form-control" value="{{ old('start_time', isset($schedule->start_time) ? substr($schedule->start_time, 0, 5) : '') }}" required>
    </div>

    {{-- Shift End: The time the doctor finishes their session on this day --}}
    <div class="col-md-4">
        <label class="form-label">End Time</label>
        <input type="time" name="end_time" class="form-control" value="{{ old('end_time', isset($schedule->end_time) ? substr($schedule->end_time, 0, 5) : '') }}" required>
    </div>

    {{-- Availability Toggle: Allows admins to quickly disable a doctor's shift (e.g., for leave or holidays) --}}
    <div class="col-md-4">
        <label class="form-label">Availability</label>
        <select name="is_available" class="form-select" required>
            <option value="1" {{ (string) old('is_available', $schedule->is_available ?? '1') === '1' ? 'selected' : '' }}>
                Available
            </option>
            <option value="0" {{ (string) old('is_available', $schedule->is_available ?? '1') === '0' ? 'selected' : '' }}>
                Not Available
            </option>
        </select>
    </div>
</div>
