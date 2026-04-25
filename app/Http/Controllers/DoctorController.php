<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $departmentId = $request->department_id;
        $status = $request->status;

        $doctors = Doctor::with('department')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('doctor_number', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('specialization', 'like', "%{$search}%")
                        ->orWhere('room_number', 'like', "%{$search}%");
                });
            })
            ->when($departmentId, function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        $departments = Department::orderBy('name')->get();

        if ($request->ajax()) {
            return view('doctors.partials.table', compact('doctors'))->render();
        }

        return view('doctors.index', compact('doctors', 'departments', 'search', 'departmentId', 'status'));
    }

    public function create()
    {
        $departments = Department::where('status', 1)
            ->orderBy('name')
            ->get();

        return view('doctors.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email|unique:doctors,email',
            'specialization' => 'nullable|string|max:255',
            'consultation_fee' => 'nullable|numeric|min:0',
            'room_number' => 'nullable|string|max:50',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:1,0',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'role' => 'doctor',
                    'is_active' => $request->status,
                    'password' => Hash::make('password123'),
                ]);

                $doctor = Doctor::create([
                    'user_id' => $user->id,
                    'doctor_number' => 'TEMP-DOC-' . $user->id,
                    'department_id' => $request->department_id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'specialization' => $request->specialization ?? 'General Medicine',
                    'consultation_fee' => $request->consultation_fee ?? 0,
                    'room_number' => $request->room_number,
                    'hire_date' => $request->hire_date ?? now()->toDateString(),
                    'status' => $request->status,
                ]);

                $doctor->doctor_number = 'DOC-' . str_pad($doctor->id, 4, '0', STR_PAD_LEFT);
                $doctor->save();
            });

            return redirect()->route('doctors.index')
                ->with('success', 'Doctor created successfully. Default password is password123.');

        } catch (QueryException $e) {
            return back()
                ->withInput()
                ->with('error', 'Database error. Please try again.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Something went wrong while creating the doctor.');
        }
    }

    public function show(Doctor $doctor)
    {
        $departments = Department::orderBy('name')->get();

        return view('doctors.show', compact('doctor', 'departments'));
    }

    public function edit(Doctor $doctor)
    {
        $departments = Department::where('status', 1)
            ->orderBy('name')
            ->get();

        return view('doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id . '|unique:users,email,' . $doctor->user_id,
            'specialization' => 'nullable|string|max:255',
            'consultation_fee' => 'nullable|numeric|min:0',
            'room_number' => 'nullable|string|max:50',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:1,0',
        ]);

        try {
            DB::transaction(function () use ($request, $doctor) {
                $doctor->update([
                    'department_id' => $request->department_id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'specialization' => $request->specialization ?? 'General Medicine',
                    'consultation_fee' => $request->consultation_fee ?? 0,
                    'room_number' => $request->room_number,
                    'hire_date' => $request->hire_date,
                    'status' => $request->status,
                ]);

                if ($doctor->user) {
                    $doctor->user->update([
                        'name' => $request->first_name . ' ' . $request->last_name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'role' => 'doctor',
                        'is_active' => $request->status,
                    ]);
                }
            });

            return redirect()->route('doctors.index')
                ->with('success', 'Doctor updated successfully.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update doctor.');
        }
    }

    public function destroy(Doctor $doctor)
    {
        try {
            DB::transaction(function () use ($doctor) {
                if ($doctor->user) {
                    $doctor->user->delete();
                }

                $doctor->delete();
            });

            return redirect()->route('doctors.index')
                ->with('success', 'Doctor deleted successfully.');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete doctor.');
        }
    }
}