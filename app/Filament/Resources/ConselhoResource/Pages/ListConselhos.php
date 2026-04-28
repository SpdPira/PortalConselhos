<?php

namespace App\Filament\Resources\ConselhoResource\Pages;

use App\Filament\Resources\ConselhoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConselhos extends ListRecords
{
    protected static string $resource = ConselhoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
