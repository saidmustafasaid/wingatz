<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidhaa extends Model
{
    protected $table = 'bidhaa';

    protected $fillable = [
        'jina', 'maelezo', 'picha', 'bei_halisi', 'bei_yangu', 'bei_jumla',
        'hali', 'kategoria', 'idadi', 'kitengo', 'idadi_ya_chini',
    ];

    protected $casts = [
        'bei_halisi'    => 'decimal:2',
        'bei_yangu'     => 'decimal:2',
        'bei_jumla'     => 'decimal:2',
        'idadi'         => 'integer',
        'idadi_ya_chini'=> 'integer',
    ];

    public function getFaidaAttribute(): float
    {
        return (float) $this->bei_yangu - (float) $this->bei_halisi;
    }

    public function getFaidaAsilimiiaAttribute(): float
    {
        if ($this->bei_halisi == 0) return 0;
        return round(($this->faida / $this->bei_halisi) * 100, 1);
    }

    public function mauzo()
    {
        return $this->hasMany(Uuzaji::class, 'bidhaa_id');
    }

    public function maswali()
    {
        return $this->hasMany(Swali::class, 'bidhaa_id');
    }

    public function scopeInapatikana($query)
    {
        return $query->where('hali', 'inapatikana');
    }

    public function scopeImeuzwa($query)
    {
        return $query->where('hali', 'imeuzwa');
    }

    public function scopeStockNdogo($query)
    {
        return $query->whereNotNull('idadi_ya_chini')
                     ->whereColumn('idadi', '<=', 'idadi_ya_chini');
    }

    public function manunuzi()
    {
        return $this->hasMany(Ununuzi::class, 'bidhaa_id');
    }

    public function getStockNdogoAttribute(): bool
    {
        return $this->idadi_ya_chini !== null && $this->idadi <= $this->idadi_ya_chini;
    }
}
