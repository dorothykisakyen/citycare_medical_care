<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relationships

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function receptionist()
    {
        return $this->hasOne(Receptionist::class);
    }

    public function cashier()
    {
        return $this->hasOne(Cashier::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}