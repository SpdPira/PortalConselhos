<?php

namespace App\Filament\Resources\ConselhoResource\Pages;

use App\Filament\Resources\ConselhoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConselho extends EditRecord
{
    protected static string $resource = ConselhoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
