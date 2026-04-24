<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentReportExport implements FromCollection, WithHeadings
{
    public function __construct(
        private ?string $dateFrom = null,
        private ?string $dateTo = null
    ) {
    }

    public function headings(): array
    {
        return [
            'Patient',
            'Amount',
            'Method',
            'Reference',
            'Date',
            'Status',
            'Cashier',
        ];
    }

    public function collection(): Collection
    {
        return Payment::with(['patient', 'cashier'])
            ->when($this->dateFrom, fn ($q) => $q->whereDate('payment_date', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($q) => $q->whereDate('payment_date', '<=', $this->dateTo))
            ->latest()
            ->get()
            ->map(function ($payment) {
                return [
                    'patient' => ($payment->patient?->first_name ?? '') . ' ' . ($payment->patient?->last_name ?? ''),
                    'amount' => $payment->amount,
                    'method' => $payment->payment_method,
                    'reference' => $payment->transaction_reference,
                    'date' => $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '',
                    'status' => $payment->status,
                    'cashier' => ($payment->cashier?->first_name ?? '') . ' ' . ($payment->cashier?->last_name ?? ''),
                ];
            });
    }
}