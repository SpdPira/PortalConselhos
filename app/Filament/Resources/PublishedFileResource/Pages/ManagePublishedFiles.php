<?php

namespace App\Filament\Resources\PublishedFileResource\Pages;

use App\Filament\Resources\PublishedFileResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePublishedFiles extends ManageRecords
{
    protected static string $resource = PublishedFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Auditoria é read-only, não deve ser criada manualmente
            // Actions\CreateAction::make(),
        ];
    }
}
