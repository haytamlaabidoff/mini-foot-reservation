<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_code',

        'post_id',
        'department_id',

        'phone',
        'cin',
        'address',
        'salary',
        'hire_date',
        'status',
        'working_hours',
        'image',
    ];

    // 👤 relation user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🏢 department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // 💼 post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // 🧠 helper (optionnel)
    public function getFullInfoAttribute()
    {
        return ($this->post?->name ?? '-') . ' - ' . ($this->department?->name ?? '-');
    }
    public function payments()
{
    return $this->hasMany(PaymentStaff::class);
}

}