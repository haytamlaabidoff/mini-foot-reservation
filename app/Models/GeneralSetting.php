<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = [
        'site_name',
        'logo',
        'phone',
        'email',
        'address',
        'city',
        'map_link',
    ];
}