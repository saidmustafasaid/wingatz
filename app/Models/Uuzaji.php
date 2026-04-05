<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uuzaji extends Model
{
    protected $table = 'mauzo';

    protected $fillable = [
        'bidhaa_id', 'mteja_id', 'bei_halisi', 'bei_iliyouzwa',
        'faida', 'siku_za_kuuza', 'maelezo', 'tarehe_ya_uuzaji',
    ];

    protected $casts = [
        'bei_halisi' => 'decimal:2',
        'bei_iliyouzwa' => 'decimal:2',
        'faida' => 'decimal:2',
        'tarehe_ya_uuzaji' => 'date',
    ];

    public function bidhaa()
    {
        return $this->belongsTo(Bidhaa::class, 'bidhaa_id');
    }

    public function mteja()
    {
        return $this->belongsTo(Mteja::class, 'mteja_id');
    }
}
