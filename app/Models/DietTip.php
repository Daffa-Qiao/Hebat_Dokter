<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietTip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'video_url',
        'source_url',
        'description',
    ];
}
