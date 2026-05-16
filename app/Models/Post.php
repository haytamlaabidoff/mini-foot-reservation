<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'department_id',
    ];

    /**
     * 📌 كل Post تابع لـ Department واحد
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * 📌 كل Post عندو عدة Staff
     */
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}