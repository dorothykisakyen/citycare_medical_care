<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ConsultationNote;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class ConsultationNoteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $consultationNotes = ConsultationNote::with(['appointment', 'patient', 'doctor'])
            ->when($search, function ($query) use ($search) {
                $query->where('diagnosis', 'like', "%{$search}%")
                    ->orWhere('prescription', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('consultation_notes.index', compact('consultationNotes', 'search'));
    }

    public function create()
    {
        $appointments = Appointment::latest()->get();
        $patients = Patient::where('status', 1)->get();
        $doctors = Doctor::where('status', 1)->get();

        return view('consultation_notes.create', compact('appointments', 'patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'treatment_notes' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
        ]);

        ConsultationNote::create($request->only([
            'appointment_id',
            'patient_id',
            'doctor_id',
            'diagnosis',
            'prescription',
            'symptoms',
            'treatment_notes',
            'follow_up_date'
        ]));

        return redirect()->route('consultation_notes.index')->with('success', 'Consultation note created successfully.');
    }

    public function edit(ConsultationNote $consultation_note)
    {
        $appointments = Appointment::latest()->get();
        $patients = Patient::where('status', 1)->get();
        $doctors = Doctor::where('status', 1)->get();

        return view('consultation_notes.edit', compact('consultation_note', 'appointments', 'patients', 'doctors'));
    }

    public function update(Request $request, ConsultationNote $consultation_note)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'diagnosis' => 'nullable|string',
            'prescription' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'treatment_notes' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
        ]);

        $consultation_note->update($request->only([
            'appointment_id',
            'patient_id',
            'doctor_id',
            'diagnosis',
            'prescription',
            'symptoms',
            'treatment_notes',
            'follow_up_date'
        ]));

        return redirect()->route('consultation_notes.index')->with('success', 'Consultation note updated successfully.');
    }

    public function show(ConsultationNote $consultation_note)
    {
        return view('consultation_notes.show', compact('consultation_note'));
    }

    public function destroy(ConsultationNote $consultation_note)
    {
        $consultation_note->delete();

        return redirect()->route('consultation_notes.index')->with('success', 'Consultation note deleted successfully.');
    }
}