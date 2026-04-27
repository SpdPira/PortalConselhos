<?php

namespace App\Filament\User\Resources\ConselhoComposicaoResource\Pages;

use App\Filament\User\Resources\ConselhoComposicaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConselhoComposicaos extends ListRecords
{
    protected static string $resource = ConselhoComposicaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
