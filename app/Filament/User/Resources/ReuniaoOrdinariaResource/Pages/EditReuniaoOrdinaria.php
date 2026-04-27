<?php
namespace App\Filament\User\Resources\ReuniaoOrdinariaResource\Pages;
use App\Filament\User\Resources\ReuniaoOrdinariaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditReuniaoOrdinaria extends EditRecord
{
    protected static string $resource = ReuniaoOrdinariaResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}