<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Str;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'terrain_id',
        'reservation_date',
        'start_time',
        'end_time',
        'status',
        'qr_token',
        'client_name',
        'client_phone',
        'created_by',
        'type',
    'day_of_week',
    "selected_months",
    "year",
    'selected_dates',
    "payment_status",
    "payment_method",
    "payment_amount",
                    "payment_date",
                    "payment_staff_id",
    'payment_method',
    ];
    protected $casts = [
    'selected_months' => 'array',
    'year' => 'integer',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function terrain()
    {
        return $this->belongsTo(Terrain::class);
    }

protected static function boot()
{
    parent::boot();

    static::creating(function ($reservation) {
        $reservation->qr_token = (string) Str::uuid();
    });
}
}