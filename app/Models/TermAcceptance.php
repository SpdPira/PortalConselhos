<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TermAcceptance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'conselho_id',
        'version',
        'ip_address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function conselho(): BelongsTo
    {
        return $this->belongsTo(Conselho::class);
    }
}
