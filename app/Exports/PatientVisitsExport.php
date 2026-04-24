<?php

namespace App\Exports;

use App\Models\Patient;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatientVisitsExport implements FromCollection, WithHeadings
{
    public function __construct(
        private ?string $dateFrom = null,
        private ?string $dateTo = null
    ) {
    }

    public function headings(): array
    {
        return [
            'Patient Number',
            'Patient Name',
            'Phone',
            'Visit Count',
            'Email',
        ];
    }

    public function collection(): Collection
    {
        return Patient::withCount([
                'appointments as filtered_appointments_count' => function ($query) {
                    $query->when($this->dateFrom, fn ($q) => $q->whereDate('appointment_date', '>=', $this->dateFrom))
                          ->when($this->dateTo, fn ($q) => $q->whereDate('appointment_date', '<=', $this->dateTo));
                }
            ])
            ->orderBy('first_name')
            ->get()
            ->map(function ($patient) {
                return [
                    'patient_number' => $patient->patient_number,
                    'patient_name' => $patient->first_name . ' ' . $patient->last_name,
                    'phone' => $patient->phone,
                    'visit_count' => $patient->filtered_appointments_count,
                    'email' => $patient->email,
                ];
            });
    }
}