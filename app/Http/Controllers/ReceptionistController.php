<?php

namespace App\Http\Controllers;

use App\Models\Receptionist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReceptionistController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $receptionists = Receptionist::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('receptionist_number', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('shift', 'like', "%{$search}%");
                });
            })
            ->when($status !== null && $status !== '', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('receptionists.index', compact('receptionists', 'search', 'status'));
    }

    public function create()
    {
        return view('receptionists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receptionist_number' => 'required|string|max:50|unique:receptionists,receptionist_number',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:receptionists,email|unique:users,email',
            'address' => 'nullable|string|max:1000',
            'shift' => 'nullable|string|max:100',
            'hire_date' => 'nullable|date',
            'status' => 'required|boolean',
            'password' => 'required|string|min:6|confirmed',
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'receptionist',
                'phone' => $validated['phone'],
                'is_active' => $validated['status'],
            ]);

            Receptionist::create([
                'user_id' => $user->id,
                'receptionist_number' => $validated['receptionist_number'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'gender' => $validated['gender'] ?? null,
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address'] ?? null,
                'shift' => $validated['shift'] ?? null,
                'hire_date' => $validated['hire_date'] ?? null,
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('receptionists.index')->with('success', 'Receptionist created successfully.');
    }

    public function show(Receptionist $receptionist)
    {
        $receptionist->load('user');
        return view('receptionists.show', compact('receptionist'));
    }

    public function edit(Receptionist $receptionist)
    {
        return view('receptionists.edit', compact('receptionist'));
    }

    public function update(Request $request, Receptionist $receptionist)
    {
        $validated = $request->validate([
            'receptionist_number' => 'required|string|max:50|unique:receptionists,receptionist_number,' . $receptionist->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:receptionists,email,' . $receptionist->id . '|unique:users,email,' . $receptionist->user_id,
            'address' => 'nullable|string|max:1000',
            'shift' => 'nullable|string|max:100',
            'hire_date' => 'nullable|date',
            'status' => 'required|boolean',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        DB::transaction(function () use ($validated, $receptionist) {
            $receptionist->user->update([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'is_active' => $validated['status'],
                ...(!empty($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
            ]);

            $receptionist->update([
                'receptionist_number' => $validated['receptionist_number'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'gender' => $validated['gender'] ?? null,
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address'] ?? null,
                'shift' => $validated['shift'] ?? null,
                'hire_date' => $validated['hire_date'] ?? null,
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('receptionists.index')->with('success', 'Receptionist updated successfully.');
    }

    public function destroy(Receptionist $receptionist)
    {
        DB::transaction(function () use ($receptionist) {
            if ($receptionist->user) {
                $receptionist->user->delete();
            }
            $receptionist->delete();
        });

        return redirect()->route('receptionists.index')->with('success', 'Receptionist deleted successfully.');
    }
}