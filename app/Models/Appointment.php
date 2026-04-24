<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'department_id',
        'receptionist_id',
        'appointment_date',
        'appointment_time',
        'end_time',
        'reason',
        'notes',
        'status',
        'cancellation_reason',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function receptionist()
    {
        return $this->belongsTo(Receptionist::class);
    }

    public function consultationNote()
    {
        return $this->hasOne(ConsultationNote::class);
    }
}