<?php

namespace App\Exports;

use App\Models\Appointment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DailyAppointmentsExport implements FromCollection, WithHeadings
{
    public function __construct(private string $date)
    {
    }

    public function headings(): array
    {
        return [
            'Patient',
            'Doctor',
            'Department',
            'Date',
            'Start Time',
            'End Time',
            'Status',
            'Reason',
        ];
    }

    public function collection(): Collection
    {
        return Appointment::with(['patient', 'doctor', 'department'])
            ->whereDate('appointment_date', $this->date)
            ->orderBy('appointment_time')
            ->get()
            ->map(function ($appointment) {
                return [
                    'patient' => ($appointment->patient?->first_name ?? '') . ' ' . ($appointment->patient?->last_name ?? ''),
                    'doctor' => ($appointment->doctor?->first_name ?? '') . ' ' . ($appointment->doctor?->last_name ?? ''),
                    'department' => $appointment->department?->name ?? 'N/A',
                    'date' => $appointment->appointment_date ? $appointment->appointment_date->format('Y-m-d') : '',
                    'start_time' => $appointment->appointment_time,
                    'end_time' => $appointment->end_time,
                    'status' => $appointment->status,
                    'reason' => $appointment->reason,
                ];
            });
    }
}