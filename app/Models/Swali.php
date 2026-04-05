<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Swali extends Model
{
    protected $table = 'maswali';

    protected $fillable = [
        'mteja_id', 'bidhaa_id', 'ujumbe', 'hali',
    ];

    public function mteja()
    {
        return $this->belongsTo(Mteja::class, 'mteja_id');
    }

    public function bidhaa()
    {
        return $this->belongsTo(Bidhaa::class, 'bidhaa_id');
    }
}
