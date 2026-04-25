<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cashier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'cashier_number',
        'first_name',
        'last_name',
        'gender',
        'phone',
        'email',
        'shift',
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

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}