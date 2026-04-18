<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthChallenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'specialization',
        'points',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function userChallenges()
    {
        return $this->hasMany(UserChallenge::class);
    }
}
