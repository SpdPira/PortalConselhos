<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarioAnexo extends Model
{
    protected $guarded = [];

    public function calendario()
    {
        return $this->belongsTo(Calendario::class, 'id_calendario');
    }
}
