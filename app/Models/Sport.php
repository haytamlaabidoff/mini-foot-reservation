<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];

    // Sport -> formats
    public function formats()
    {
        return $this->hasMany(SportFormat::class);
    }
    
}