<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConselhoComposicao extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function conselho()
    {
        return $this->belongsTo(Conselho::class, 'id_conselho');
    }
}
