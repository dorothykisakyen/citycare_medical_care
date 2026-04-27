<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ConsultationNote;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
{
    return view('dashboards.admin', [
        'totalPatients' => Patient::count(),
        'totalDoctors' => Doctor::count(),
        'totalAppointments' => Appointment::count(),
        'totalUsers' => User::count(),
        'totalDepartments' => Department::count(),

        'totalReceptionists' => User::where('role', 'receptionist')->count(),
        'totalCashiers' => User::where('role', 'cashier')->count(),

        'totalPatientsTreated' => ConsultationNote::distinct('patient_id')->count('patient_id'),

        'totalRevenue' => Payment::where('status', 'paid')->sum('amount'),
        'totalPayments' => Payment::where('status', 'paid')->sum('amount'),

        'todayRevenue' => Payment::where('status', 'paid')
            ->whereDate('payment_date', today())
            ->sum('amount'),

        'weeklyRevenue' => Payment::where('status', 'paid')
            ->whereBetween('payment_date', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString(),
            ])
            ->sum('amount'),

        'monthlyRevenue' => Payment::where('status', 'paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount'),

        'pendingAppointments' => Appointment::where('status', 'pending')->count(),
        'confirmedAppointments' => Appointment::where('status', 'confirmed')->count(),
        'completedAppointments' => Appointment::where('status', 'completed')->count(),
        'cancelledAppointments' => Appointment::where('status', 'cancelled')->count(),

        'malePatients' => Patient::whereIn('gender', ['male', 'Male', 'MALE'])->count(),
        'femalePatients' => Patient::whereIn('gender', ['female', 'Female', 'FEMALE'])->count(),

        'maleDoctors' => Doctor::whereIn('gender', ['male', 'Male', 'MALE'])->count(),
        'femaleDoctors' => Doctor::whereIn('gender', ['female', 'Female', 'FEMALE'])->count(),

        'recentAppointments' => Appointment::with(['patient', 'doctor', 'department'])
            ->latest()
            ->take(5)
            ->get(),

        'recentPayments' => Payment::with(['patient', 'appointment'])
            ->latest()
            ->take(5)
            ->get(),
    ]);
}

    public function receptionist()
{
    return view('dashboards.receptionist', [
        'totalPatients' => Patient::count(),

        'todayAppointments' => Appointment::whereDate('appointment_date', today())->count(),

        'pendingAppointments' => Appointment::where('status', 'pending')->count(),

        'confirmedAppointments' => Appointment::where('status', 'confirmed')->count(),

        'completedAppointments' => Appointment::where('status', 'completed')->count(),

        'cancelledAppointments' => Appointment::where('status', 'cancelled')->count(),

        'doctors' => Doctor::count(),

        'recentAppointments' => Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->take(5)
            ->get(),
    ]);
}

    public function doctor()
    {
        $user = Auth::user();

        $doctor = Doctor::where('user_id', $user->id)->first();

        return view('dashboards.doctor', [
            'doctor' => $doctor,

            'todayAppointments' => $doctor
                ? Appointment::where('doctor_id', $doctor->id)
                    ->whereDate('appointment_date', today())
                    ->count()
                : 0,

            'totalDoctorAppointments' => $doctor
                ? Appointment::where('doctor_id', $doctor->id)->count()
                : 0,

            'totalConsultations' => $doctor
                ? ConsultationNote::where('doctor_id', $doctor->id)->count()
                : 0,

            'treatedPatients' => $doctor
                ? ConsultationNote::where('doctor_id', $doctor->id)
                    ->distinct('patient_id')
                    ->count('patient_id')
                : 0,

            'appointments' => $doctor
                ? Appointment::with('patient')
                    ->where('doctor_id', $doctor->id)
                    ->latest()
                    ->take(5)
                    ->get()
                : collect(),

            'recentConsultations' => $doctor
                ? ConsultationNote::with('patient')
                    ->where('doctor_id', $doctor->id)
                    ->latest()
                    ->take(5)
                    ->get()
                : collect(),
        ]);
    }

    public function cashier()
{
    return view('dashboards.cashier', [
        'todayPayments' => Payment::whereDate('created_at', today())->sum('amount'),

        'weeklyPayments' => Payment::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->sum('amount'),

        'monthlyPayments' => Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount'),

        'totalPayments' => Payment::sum('amount'),

        'paymentCount' => Payment::count(),
        'paidPayments' => Payment::where('status', 'paid')->count(),
        'pendingPayments' => Payment::where('status', 'pending')->count(),
        'failedPayments' => Payment::where('status', 'failed')->count(),

        'recentPayments' => Payment::with(['patient', 'appointment'])
            ->latest()
            ->take(8)
            ->get(),
    ]);
}
    public function patient()
{
    $user = Auth::user();

    $patient = Patient::where('user_id', $user->id)->first();

    return view('dashboards.patient', [
        'patient' => $patient,

        'upcomingAppointments' => $patient
            ? Appointment::with('doctor')
                ->where('patient_id', $patient->id)
                ->whereDate('appointment_date', '>=', today())
                ->latest()
                ->take(5)
                ->get()
            : collect(),

        'upcomingAppointmentsCount' => $patient
            ? Appointment::where('patient_id', $patient->id)
                ->whereDate('appointment_date', '>=', today())
                ->count()
            : 0,

        'visitHistory' => $patient
            ? ConsultationNote::with('doctor')
                ->where('patient_id', $patient->id)
                ->latest()
                ->take(5)
                ->get()
            : collect(),

        'visitHistoryCount' => $patient
            ? ConsultationNote::where('patient_id', $patient->id)->count()
            : 0,

        'payments' => $patient
            ? Payment::with('appointment')
                ->where('patient_id', $patient->id)
                ->latest()
                ->take(5)
                ->get()
            : collect(),

        'paymentCount' => $patient
            ? Payment::where('patient_id', $patient->id)->count()
            : 0,

        'totalPaid' => $patient
            ? Payment::where('patient_id', $patient->id)
                ->where('status', 'paid')
                ->sum('amount')
            : 0,
    ]);
}
}