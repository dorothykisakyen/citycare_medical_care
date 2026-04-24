<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function global(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $patients = collect();
        $doctors = collect();
        $departments = collect();
        $appointments = collect();
        $payments = collect();

        if ($q !== '') {
            $patients = Patient::where(function ($query) use ($q) {
                $query->where('patient_number', 'like', "%{$q}%")
                    ->orWhere('first_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$q}%"])
                    ->orWhere('phone', 'like', "%{$q}%");
            })->limit(8)->get();

            $doctors = Doctor::with('department')
                ->where(function ($query) use ($q) {
                    $query->where('doctor_number', 'like', "%{$q}%")
                        ->orWhere('first_name', 'like', "%{$q}%")
                        ->orWhere('last_name', 'like', "%{$q}%")
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$q}%"])
                        ->orWhere('specialization', 'like', "%{$q}%")
                        ->orWhere('phone', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                })
                ->orWhereHas('department', function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%");
                })
                ->limit(8)
                ->get();

            $departments = Department::where('name', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%")
                ->limit(8)
                ->get();

            $appointments = Appointment::with(['patient', 'doctor', 'department'])
                ->where(function ($query) use ($q) {
                    $query->where('reason', 'like', "%{$q}%")
                        ->orWhere('status', 'like', "%{$q}%")
                        ->orWhereHas('patient', function ($patientQuery) use ($q) {
                            $patientQuery->where('first_name', 'like', "%{$q}%")
                                ->orWhere('last_name', 'like', "%{$q}%")
                                ->orWhere('patient_number', 'like', "%{$q}%");
                        })
                        ->orWhereHas('doctor', function ($doctorQuery) use ($q) {
                            $doctorQuery->where('first_name', 'like', "%{$q}%")
                                ->orWhere('last_name', 'like', "%{$q}%")
                                ->orWhere('doctor_number', 'like', "%{$q}%");
                        });
                })
                ->limit(8)
                ->get();

            $payments = Payment::with(['patient', 'cashier'])
                ->where('transaction_reference', 'like', "%{$q}%")
                ->orWhere('payment_method', 'like', "%{$q}%")
                ->orWhereHas('patient', function ($patientQuery) use ($q) {
                    $patientQuery->where('first_name', 'like', "%{$q}%")
                        ->orWhere('last_name', 'like', "%{$q}%")
                        ->orWhere('patient_number', 'like', "%{$q}%");
                })
                ->limit(8)
                ->get();
        }

        return view('search.global', compact('q', 'patients', 'doctors', 'departments', 'appointments', 'payments'));
    }
}