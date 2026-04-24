<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Msambazaji extends Model
{
    protected $table = 'wasambazaji';

    protected $fillable = [
        'jina', 'simu', 'whatsapp', 'bidhaa_wanazouza', 'maelezo',
    ];

    public function manunuzi()
    {
        return $this->hasMany(Ununuzi::class, 'msambazaji_id');
    }

    public function getJumlaManunuziAttribute(): float
    {
        return (float) $this->manunuzi()->sum('jumla');
    }
}
