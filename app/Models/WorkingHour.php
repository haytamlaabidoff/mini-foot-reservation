<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    protected $fillable = [
    'days',
    'open_time',
    'close_time',
    'is_closed',
    'note',
];


protected $casts = [
    'days' => 'array',
];
}