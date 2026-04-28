<?php

namespace App\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Model;

class Conselho extends Model implements HasName
{
    protected $guarded = [];

    public function getFilamentName(): string
    {
        return $this->nome;
    }

    public function composicoes()
    {
        return $this->hasMany(ConselhoComposicao::class, 'id_conselho');
    }

    public function calendarios()
    {
        return $this->hasMany(Calendario::class, 'id_conselho');
    }
}
