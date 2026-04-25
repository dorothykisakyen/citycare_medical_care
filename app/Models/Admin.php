<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'admin_number',
        'first_name',
        'last_name',
        'gender',
        'phone',
        'email',
        'address',
        'job_title',	
        'hire_date',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'created_by_admin_id');
    }
}