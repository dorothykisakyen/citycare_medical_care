<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CashierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $cashiers = Cashier::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('cashier_number', 'like', "%{$search}%")
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

        return view('cashiers.index', compact('cashiers', 'search', 'status'));
    }

    public function create()
    {
        return view('cashiers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cashier_number' => 'required|string|max:50|unique:cashiers,cashier_number',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:cashiers,email|unique:users,email',
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
                'role' => 'cashier',
                'phone' => $validated['phone'],
                'is_active' => $validated['status'],
            ]);

            Cashier::create([
                'user_id' => $user->id,
                'cashier_number' => $validated['cashier_number'],
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

        return redirect()->route('cashiers.index')->with('success', 'Cashier created successfully.');
    }

    public function show(Cashier $cashier)
    {
        $cashier->load('user');
        return view('cashiers.show', compact('cashier'));
    }

    public function edit(Cashier $cashier)
    {
        return view('cashiers.edit', compact('cashier'));
    }

    public function update(Request $request, Cashier $cashier)
    {
        $validated = $request->validate([
            'cashier_number' => 'required|string|max:50|unique:cashiers,cashier_number,' . $cashier->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:cashiers,email,' . $cashier->id . '|unique:users,email,' . $cashier->user_id,
            'address' => 'nullable|string|max:1000',
            'shift' => 'nullable|string|max:100',
            'hire_date' => 'nullable|date',
            'status' => 'required|boolean',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        DB::transaction(function () use ($validated, $cashier) {
            $cashier->user->update([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'is_active' => $validated['status'],
                ...(!empty($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
            ]);

            $cashier->update([
                'cashier_number' => $validated['cashier_number'],
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

        return redirect()->route('cashiers.index')->with('success', 'Cashier updated successfully.');
    }

    public function destroy(Cashier $cashier)
    {
        DB::transaction(function () use ($cashier) {
            if ($cashier->user) {
                $cashier->user->delete();
            }
            $cashier->delete();
        });

        return redirect()->route('cashiers.index')->with('success', 'Cashier deleted successfully.');
    }
}