<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $doctorId = $request->doctor_id;
        $day = $request->day_of_week;

        $schedules = Schedule::with('doctor')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('day_of_week', 'like', "%{$search}%")
                      ->orWhere('start_time', 'like', "%{$search}%")
                      ->orWhere('end_time', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->when($doctorId, function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->when($day, function ($query) use ($day) {
                $query->where('day_of_week', $day);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $doctors = Doctor::orderBy('first_name')->get();

        return view('schedules.index', compact(
            'schedules',
            'doctors',
            'search',
            'doctorId',
            'day'
        ));
    }

    public function create()
    {
        $doctors = Doctor::where('status', 1)
            ->orderBy('first_name')
            ->get();

        return view('schedules.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'is_available' => 'required|boolean',
        ]);

        Schedule::create($request->only([
            'doctor_id',
            'day_of_week',
            'start_time',
            'end_time',
            'is_available',
        ]));

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule)
    {
        $doctors = Doctor::where('status', 1)
            ->orderBy('first_name')
            ->get();

        return view('schedules.edit', compact('schedule', 'doctors'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'is_available' => 'required|boolean',
        ]);

        $schedule->update($request->only([
            'doctor_id',
            'day_of_week',
            'start_time',
            'end_time',
            'is_available',
        ]));

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}