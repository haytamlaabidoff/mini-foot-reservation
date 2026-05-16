<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'terrain_id',
        'name',
        'quantity',
        'condition',
        'description',
    ];

    public function terrain()
    {
        return $this->belongsTo(Terrain::class);
    }
}