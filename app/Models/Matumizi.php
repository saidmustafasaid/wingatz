<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matumizi extends Model
{
    protected $table = 'matumizi';

    protected $fillable = [
        'kichwa', 'kiasi', 'kategoria', 'tarehe', 'maelezo',
    ];

    protected $casts = [
        'kiasi'  => 'decimal:2',
        'tarehe' => 'date',
    ];
}
