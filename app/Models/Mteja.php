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

}
