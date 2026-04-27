<?php
namespace App\Filament\User\Resources\ReuniaoExtraordinariaResource\Pages;
use App\Filament\User\Resources\ReuniaoExtraordinariaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditReuniaoExtraordinaria extends EditRecord
{
    protected static string $resource = ReuniaoExtraordinariaResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}