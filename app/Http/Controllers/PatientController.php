<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $patients = Patient::when($search, function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('patient_number', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('patients.index', compact('patients', 'search'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string|max:500',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'status' => 'required|in:1,0',
        ]);

        try {
            // Step 1: Create without patient_number
            $patient = Patient::create([
                'patient_number' => null,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'blood_group' => $request->blood_group,
                'phone' => $request->phone,
                'email' => $request->email,
                'registration_date' =>$request->registration_date??now()->toDateString(),
                'address' => $request->address,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'status' => $request->status,
            ]);

            // Step 2: Generate patient number from ID
            $patient->patient_number = 'PAT-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
            $patient->save();

            return redirect()->route('patients.index')
                ->with('success', 'Patient created successfully.');

        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->with('error', 'Database error. Please try again.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Something went wrong.');
        }
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string|max:500',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'status' => 'required|in:1,0',
        ]);

        try {
            $patient->update($request->only([
                'user_id',
                'first_name',
                'last_name',
                'gender',
                'date_of_birth',
                'blood_group',
                'phone',
                'email',
                'address',
                'emergency_contact_name',
                'emergency_contact_phone',
                'status',
            ]));

            return redirect()->route('patients.index')
                ->with('success', 'Patient updated successfully.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update patient.');
        }
    }

    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();

            return redirect()->route('patients.index')
                ->with('success', 'Patient deleted successfully.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete patient.');
        }
    }
}