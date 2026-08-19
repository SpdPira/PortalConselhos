<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PublishedFile extends Model
{
    protected $fillable = [
        'user_id',
        'file_name',
        'file_path',
        'file_size',
        'file_hash',
        'mime_type',
        'meta_data',
        'ip_address',
        'user_agent',
        'publishable_type',
        'publishable_id',
        'action',
    ];

    protected $casts = [
        'meta_data' => 'array',
    ];

    /**
     * Relacionamento com o usuário que publicou o arquivo.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento polimórfico com o recurso que possui o arquivo (News, Document, Service).
     */
    public function publishable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Auxiliar para auditar o arquivo físico e registrar na tabela de logs.
     */
    public static function auditAndLog($model, ?string $filePath, string $action): void
    {
        if (empty($filePath)) {
            return;
        }

        // Procura no disco público ou no root do storage
        $storagePath = storage_path('app/public/' . $filePath);
        if (!file_exists($storagePath)) {
            $storagePath = storage_path('app/' . $filePath);
        }
        if (!file_exists($storagePath)) {
            $storagePath = public_path($filePath);
        }

        if (file_exists($storagePath)) {
            $originalName = basename($filePath);
            $audit = \App\Services\FileAuditService::auditFile($storagePath, $originalName);

            self::create([
                'user_id' => auth()->id(),
                'file_name' => $originalName,
                'file_path' => $filePath,
                'file_size' => filesize($storagePath),
                'file_hash' => $audit['hash'],
                'mime_type' => $audit['mime_type'],
                'meta_data' => $audit['meta'],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'publishable_type' => get_class($model),
                'publishable_id' => $model->id,
                'action' => $action,
            ]);
        }
    }
}
