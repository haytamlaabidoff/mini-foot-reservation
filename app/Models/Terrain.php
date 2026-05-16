<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terrain extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'name',
        'price_per_hour',
        'status',
        'number_of_days',
        'type',
        'terrain_condition',
        'sport_id',
        'sport_format_id',
        'sport_type',
        "format",
    ];

    /* ================= SPORT ================= */
    public function sport()
    {
        return $this->belongsTo(Sport::class, 'sport_id');
    }

    /* ================= FORMAT ================= */
    public function sportFormat()
    {
        return $this->belongsTo(SportFormat::class, 'sport_format_id');
    }

    /* ================= RESERVATIONS ================= */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public function materials()
{
    return $this->hasMany(Material::class);
}
}