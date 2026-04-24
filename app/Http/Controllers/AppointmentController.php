<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;
    $doctorId = $request->doctor_id;
    $status = $request->status;
    $date = $request->appointment_date;

    $appointments = Appointment::with(['patient', 'doctor', 'department'])
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('appointment_number', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        })
        ->when($doctorId, function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })
        ->when($status !== null && $status !== '', function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->when($date, function ($query) use ($date) {
            $query->whereDate('appointment_date', $date);
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    $doctors = Doctor::orderBy('first_name')->get();

    return view('appointments.index', compact(
        'appointments',
        'doctors',
        'search',
        'doctorId',
        'status',
        'date'
    ));
}

    public function create()
    {
        $patients = Patient::where('status', 1)->get();
        $doctors = Doctor::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();

        return view('appointments.create', compact('patients', 'doctors', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'required|exists:departments,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'end_time'=>'required',
            'reason' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'This doctor is already booked at the selected date and time.');
        }

        Appointment::create([
            'appointment_number' => 'APP-' . str_pad((Appointment::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT),
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'end_time' =>$request->end_time,
            'reason' => $request->reason,
            'status' => $request->status,
            'booked_by' => Auth::id(),
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'department']);

        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::where('status', 1)->get();
        $doctors = Doctor::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'departments'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'department_id' => 'required|exists:departments,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'end_time'=>'required',
            'reason' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->where('id', '!=', $appointment->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'This doctor is already booked at the selected date and time.');
        }

        $appointment->update($request->only([
            'patient_id',
            'doctor_id',
            'department_id',
            'appointment_date',
            'appointment_time',
            'end_time',
            'reason',
            'status',
        ]));

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}