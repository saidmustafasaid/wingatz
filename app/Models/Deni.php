<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deni extends Model
{
    protected $table = 'madeni';

    protected $fillable = [
        'mteja_id', 'kiasi', 'aina', 'tarehe', 'tarehe_ya_kulipa', 'hali', 'maelezo',
    ];

    protected $casts = [
        'kiasi'           => 'decimal:2',
        'tarehe'          => 'date',
        'tarehe_ya_kulipa'=> 'date',
    ];

    public function mteja()
    {
        return $this->belongsTo(Mteja::class, 'mteja_id');
    }

    public function scopeHaijalipiwa($query)
    {
        return $query->where('hali', 'haijalipiwa')->where('aina', 'deni');
    }
}
