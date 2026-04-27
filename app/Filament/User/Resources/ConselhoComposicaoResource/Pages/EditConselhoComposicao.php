<?php

namespace App\Filament\User\Resources\ConselhoComposicaoResource\Pages;

use App\Filament\User\Resources\ConselhoComposicaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConselhoComposicao extends EditRecord
{
    protected static string $resource = ConselhoComposicaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
