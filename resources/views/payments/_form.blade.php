<div class="row g-3">
    {{-- Patient Selection: Links the payment to a specific registered patient --}}
    <div class="col-md-6">
        <label class="form-label">Patient</label>
        <select name="patient_id" class="form-select" required>
            <option value="">Select Patient</option>
            @foreach($patients as $patientOption)
                <option value="{{ $patientOption->id }}" {{ (string)old('patient_id', $payment->patient_id ?? '') === (string)$patientOption->id ? 'selected' : '' }}>
                    {{ $patientOption->patient_number }} - {{ $patientOption->first_name }} {{ $patientOption->last_name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Appointment Link: Optional field to associate this payment with a specific clinical visit --}}
    <div class="col-md-6">
        <label class="form-label">Appointment</label>
        <select name="appointment_id" class="form-select">
            <option value="">Optional Appointment Link</option>
            @foreach($appointments as $appointmentOption)
                <option value="{{ $appointmentOption->id }}" {{ (string)old('appointment_id', $payment->appointment_id ?? '') === (string)$appointmentOption->id ? 'selected' : '' }}>
                    {{ $appointmentOption->patient->first_name ?? '' }} {{ $appointmentOption->patient->last_name ?? '' }} - {{ $appointmentOption->appointment_date->format('d M Y') }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Financial Data: The monetary value of the transaction --}}
    <div class="col-md-4">
        <label class="form-label">Amount</label>
        <input type="number" step="0.01" min="0" name="amount" class="form-control" value="{{ old('amount', $payment->amount ?? '') }}" required>
    </div>

    {{-- Mode of Payment: Categorizes how the money was received (Cash, Card, etc.) --}}
    <div class="col-md-4">
        <label class="form-label">Payment Method</label>
        <select name="payment_method" class="form-select" required>
            @foreach(['cash'=>'Cash','mobile_money'=>'Mobile Money','card'=>'Card','bank'=>'Bank'] as $value => $label)
                <option value="{{ $value }}" {{ old('payment_method', $payment->payment_method ?? '') === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    {{-- Transaction Date: Defaults to current date if no record exists --}}
    <div class="col-md-4">
        <label class="form-label">Payment Date</label>
        <input type="date" name="payment_date" class="form-control" value="{{ old('payment_date', isset($payment->payment_date) ? $payment->payment_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
    </div>

    {{-- Reference Tracking: External ID for bank transfers, card receipts, or mobile money tokens --}}
    <div class="col-md-6">
        <label class="form-label">Transaction Reference</label>
        <input type="text" name="transaction_reference" class="form-control" value="{{ old('transaction_reference', $payment->transaction_reference ?? '') }}">
    </div>

    {{-- Workflow Status: Tracks if the payment is complete, pending verification, or rejected --}}
    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            @foreach(['paid'=>'Paid','pending'=>'Pending','failed'=>'Failed'] as $value => $label)
                <option value="{{ $value }}" {{ old('status', $payment->status ?? 'paid') === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    {{-- Internal Memo: Additional details regarding the transaction --}}
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $payment->notes ?? '') }}</textarea>
    </div>
</div>
