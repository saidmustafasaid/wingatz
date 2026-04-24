<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ununuzi extends Model
{
    protected $table = 'manunuzi';

    protected $fillable = [
        'bidhaa_id', 'msambazaji_id', 'idadi', 'bei_ya_kununulia', 'tarehe', 'maelezo',
    ];

    protected $casts = [
        'bei_ya_kununulia' => 'decimal:2',
        'tarehe'           => 'date',
        'idadi'            => 'integer',
    ];

    public function bidhaa()
    {
        return $this->belongsTo(Bidhaa::class, 'bidhaa_id');
    }

    public function msambazaji()
    {
        return $this->belongsTo(Msambazaji::class, 'msambazaji_id');
    }

    public function getJumlaAttribute(): float
    {
        return (float) $this->idadi * (float) $this->bei_ya_kununulia;
    }
}
