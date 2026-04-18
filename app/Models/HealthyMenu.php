<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthyMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'calories',
        'category',
        'specialization',
        'doctor_id',
        'image',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
