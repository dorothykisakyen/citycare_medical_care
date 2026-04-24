<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Department;

class Doctor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'doctor_number',
        'first_name',
        'last_name',
        'gender',
        'phone',
        'email',
        'specialization',
        'consultation_fee',
        'room_number',
        'hire_date',
        'status',
    ];

    protected $casts = [
        'consultation_fee' => 'decimal:2',
        'hire_date' => 'date',
        'status' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function consultationNotes()
    {
        return $this->hasMany(ConsultationNote::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}