<?php

namespace App\Http\Controllers;

use App\Exports\DailyAppointmentsExport;
use App\Exports\DoctorSchedulesExport;
use App\Exports\PatientVisitsExport;
use App\Exports\PaymentReportExport;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Patient;
use App\Models\Schedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function dailyAppointments(Request $request)
    {
        $date = $request->date ?? now()->toDateString();

        if ($request->format === 'xlsx') {
            return Excel::download(new DailyAppointmentsExport($date), 'daily_appointments_' . $date . '.xlsx');
        }

        $appointments = Appointment::with(['patient', 'doctor', 'department'])
            ->whereDate('appointment_date', $date)
            ->orderBy('appointment_time')
            ->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf.daily-appointments', compact('appointments', 'date'));
            return $pdf->download('daily_appointments_' . $date . '.pdf');
        }

        return $this->csvResponse(
            'daily_appointments_' . $date . '.csv',
            ['Patient', 'Doctor', 'Department', 'Date', 'Start Time', 'End Time', 'Status', 'Reason'],
            $appointments->map(fn ($a) => [
                $a->patient?->first_name . ' ' . $a->patient?->last_name,
                $a->doctor?->first_name . ' ' . $a->doctor?->last_name,
                $a->department?->name,
                $a->appointment_date?->format('Y-m-d'),
                $a->appointment_time,
                $a->end_time,
                $a->status,
                $a->reason,
            ])->toArray()
        );
    }

    public function doctorSchedules(Request $request)
    {
        if ($request->format === 'xlsx') {
            return Excel::download(new DoctorSchedulesExport(), 'doctor_schedules_report.xlsx');
        }

        $schedules = Schedule::with(['doctor.department'])
            ->orderBy('day_of_week')
            ->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf.doctor-schedules', compact('schedules'));
            return $pdf->download('doctor_schedules_report.pdf');
        }

        return $this->csvResponse(
            'doctor_schedules_report.csv',
            ['Doctor Number', 'Doctor Name', 'Department', 'Day', 'Start Time', 'End Time', 'Slot Duration', 'Availability'],
            $schedules->map(fn ($s) => [
                $s->doctor?->doctor_number,
                $s->doctor?->first_name . ' ' . $s->doctor?->last_name,
                $s->doctor?->department?->name,
                $s->day_of_week,
                $s->start_time,
                $s->end_time,
                $s->slot_duration . ' min',
                $s->is_available ? 'Available' : 'Not Available',
            ])->toArray()
        );
    }

    public function paymentReport(Request $request)
    {
        if ($request->format === 'xlsx') {
            return Excel::download(
                new PaymentReportExport($request->date_from, $request->date_to),
                'payment_report.xlsx'
            );
        }

        $payments = Payment::with(['patient', 'cashier'])
            ->when($request->date_from, fn ($q) => $q->whereDate('payment_date', '>=', $request->date_from))
            ->when($request->date_to, fn ($q) => $q->whereDate('payment_date', '<=', $request->date_to))
            ->latest()
            ->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf.payment-report', compact('payments'));
            return $pdf->download('payment_report.pdf');
        }

        return $this->csvResponse(
            'payment_report.csv',
            ['Patient', 'Amount', 'Method', 'Reference', 'Date', 'Status', 'Cashier'],
            $payments->map(fn ($p) => [
                $p->patient?->first_name . ' ' . $p->patient?->last_name,
                $p->amount,
                $p->payment_method,
                $p->transaction_reference,
                $p->payment_date?->format('Y-m-d'),
                $p->status,
                $p->cashier?->first_name . ' ' . $p->cashier?->last_name,
            ])->toArray()
        );
    }

    public function patientVisits(Request $request)
    {
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        if ($request->format === 'xlsx') {
            return Excel::download(
                new PatientVisitsExport($dateFrom, $dateTo),
                'patient_visits_report.xlsx'
            );
        }

        $patients = Patient::withCount([
                'appointments as filtered_appointments_count' => function ($query) use ($dateFrom, $dateTo) {
                    $query->when($dateFrom, fn ($q) => $q->whereDate('appointment_date', '>=', $dateFrom))
                          ->when($dateTo, fn ($q) => $q->whereDate('appointment_date', '<=', $dateTo));
                }
            ])
            ->orderBy('first_name')
            ->get();

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdf.patient-visits', compact('patients', 'dateFrom', 'dateTo'));
            return $pdf->download('patient_visits_report.pdf');
        }

        return $this->csvResponse(
            'patient_visits_report.csv',
            ['Patient Number', 'Patient Name', 'Phone', 'Visit Count', 'Email'],
            $patients->map(fn ($p) => [
                $p->patient_number,
                $p->first_name . ' ' . $p->last_name,
                $p->phone,
                $p->filtered_appointments_count,
                $p->email,
            ])->toArray()
        );
    }

    private function csvResponse(string $filename, array $headers, array $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $rows) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($rows as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}