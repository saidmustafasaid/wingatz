<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidhaa extends Model
{
    protected $table = 'bidhaa';

    protected $fillable = [
        'jina', 'maelezo', 'picha', 'bei_halisi', 'bei_yangu', 'hali', 'kategoria',
    ];

    protected $casts = [
        'bei_halisi' => 'decimal:2',
        'bei_yangu' => 'decimal:2',
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
}
