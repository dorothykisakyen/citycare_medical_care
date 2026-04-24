<?php

namespace App\Exports;

use App\Models\Schedule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DoctorSchedulesExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Doctor Number',
            'Doctor Name',
            'Department',
            'Day',
            'Start Time',
            'End Time',
            'Slot Duration',
            'Availability',
        ];
    }

    public function collection(): Collection
    {
        return Schedule::with(['doctor.department'])
            ->orderBy('day_of_week')
            ->get()
            ->map(function ($schedule) {
                return [
                    'doctor_number' => $schedule->doctor?->doctor_number,
                    'doctor_name' => ($schedule->doctor?->first_name ?? '') . ' ' . ($schedule->doctor?->last_name ?? ''),
                    'department' => $schedule->doctor?->department?->name ?? 'N/A',
                    'day' => $schedule->day_of_week,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'slot_duration' => $schedule->slot_duration . ' min',
                    'availability' => $schedule->is_available ? 'Available' : 'Not Available',
                ];
            });
    }
}