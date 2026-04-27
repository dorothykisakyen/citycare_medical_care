<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;
        $method = $request->payment_method;

        $payments = Payment::when($search, function ($query) use ($search) {
                $query->where('payment_number', 'like', "%{$search}%")
                      ->orWhere('transaction_reference', 'like', "%{$search}%");
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($method, function ($query) use ($method) {
                $query->where('payment_method', $method);
            })
            ->latest()
            ->paginate(10);

        return view('payments.index', compact('payments', 'search', 'status', 'method'));
    }

    public function create()
    {
        $patients = Patient::where('status', 1)->get();
        $appointments = Appointment::latest()->get();

        return view('payments.create', compact('patients', 'appointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,bank,mobile_money,card',
            'payment_date' => 'required|date',
            'status' => 'required|in:paid,pending,failed',
            'transaction_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Payment::create([
            'payment_number' => 'PAY-' . str_pad((Payment::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT),
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'cashier_id' => auth()->user()->cashier?->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'status' => $request->status,
            'transaction_reference' => $request->transaction_reference,
            'notes' => $request->notes,
            'received_by' => Auth::id(),
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load(['patient', 'appointment']);

        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $patients = Patient::where('status', 1)->get();
        $appointments = Appointment::latest()->get();

        return view('payments.edit', compact('payment', 'patients', 'appointments'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:cash,bank,mobile_money,card',
            'payment_date' => 'required|date',
            'status' => 'required|in:paid,pending,failed',
            'transaction_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $payment->update([
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'status' => $request->status,
            'transaction_reference' => $request->transaction_reference,
            'notes' => $request->notes,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }
}