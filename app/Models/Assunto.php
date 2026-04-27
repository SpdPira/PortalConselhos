<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    protected $guarded = [];

    public function calendarios()
    {
        return $this->hasMany(Calendario::class, 'id_assunto');
    }
}
