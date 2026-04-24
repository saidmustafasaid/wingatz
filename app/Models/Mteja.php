<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mteja extends Model
{
    protected $table = 'wateja';

    protected $fillable = [
        'jina', 'simu', 'whatsapp', 'maelezo',
    ];

    public function mauzo()
    {
        return $this->hasMany(Uuzaji::class, 'mteja_id');
    }

    public function maswali()
    {
        return $this->hasMany(Swali::class, 'mteja_id');
    }

    public function madeni()
    {
        return $this->hasMany(Deni::class, 'mteja_id');
    }

    public function getDeniHalijaliwiwAttribute(): float
    {
        return (float) $this->madeni()->where('aina', 'deni')->where('hali', 'haijalipiwa')->sum('kiasi')
             - (float) $this->madeni()->where('aina', 'malipo')->sum('kiasi');
    }
}
