<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SportFormat extends Model
{
    protected $fillable = [
        'sport_id',
        'name',
        'players_count',
        'duration',
        'default_price',
        'status'
    ];

    // Format belongs to Sport
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    // Format -> terrains
    public function terrains()
    {
        return $this->hasMany(Terrain::class);
    }
}