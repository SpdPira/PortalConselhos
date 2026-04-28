<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendario extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'data' => 'date',
            'hora' => 'datetime:H:i',
        ];
    }

    public function conselho()
    {
        return $this->belongsTo(Conselho::class, 'id_conselho');
    }

    public function assunto()
    {
        return $this->belongsTo(Assunto::class, 'id_assunto');
    }

    public function anexos()
    {
        return $this->hasMany(CalendarioAnexo::class, 'id_calendario');
    }
}
