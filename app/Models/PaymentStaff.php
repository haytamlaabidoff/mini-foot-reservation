<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'amount',
        'month',
        'status',
        'paid_by',
        'paid_at',
        'note',
        'next_payment_at',
    ];

    // 🔥 IMPORTANT FIX
    protected $casts = [
        'paid_at' => 'datetime',
        'next_payment_at' => 'datetime',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}