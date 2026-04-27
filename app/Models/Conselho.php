<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conselho extends Model
{
    protected $guarded = [];

    public function composicoes()
    {
        return $this->hasMany(ConselhoComposicao::class, 'id_conselho');
    }

    public function calendarios()
    {
        return $this->hasMany(Calendario::class, 'id_conselho');
    }
}
