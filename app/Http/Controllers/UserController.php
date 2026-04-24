<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Cashier;
use App\Models\Receptionist;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $role = $request->role;

        $users = User::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            })
            ->when($role, function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'search', 'role'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'nullable|string|max:20',
        'role' => 'required|in:admin,receptionist,doctor,cashier,patient',
        'is_active' => 'required|in:1,0',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'role' => $request->role,
        'is_active' => $request->is_active,
        'password' => Hash::make($request->password),
    ]);

    $nameParts = explode(' ', $request->name, 2);
    $firstName = $nameParts[0];
    $lastName = $nameParts[1] ?? '';

    if ($request->role === 'admin') {
        Admin::create([
            'user_id' => $user->id,
            'admin_number'=>'ADM'.str_pad($user->id,4,'0',STR_PAD_LEFT),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => 1,
        ]);
    }

    if ($request->role === 'receptionist') {
        Receptionist::create([
            'user_id' => $user->id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => 1,
        ]);
    }

    if ($request->role === 'cashier') {
        Cashier::create([
            'user_id' => $user->id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => 1,
        ]);
    }

    if ($request->role === 'patient') {
        $patient = Patient::create([
            'user_id' => $user->id,
            'patient_number' => null,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => 'male',
            'date_of_birth' => now()->subYears(18)->toDateString(),
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => 1,
        ]);

        $patient->patient_number = 'PAT-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
        $patient->save();
    }

    return redirect()->route('users.index')->with('success', 'User created successfully.');
}

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,receptionist,doctor,cashier,patient',
            'is_active' => 'required|in:1,0',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only([
            'name',
            'email',
            'phone',
            'role',
            'is_active',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}