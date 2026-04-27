<?php
namespace App\Filament\User\Resources\AtaResource\Pages;
use App\Filament\User\Resources\AtaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditAta extends EditRecord
{
    protected static string $resource = AtaResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}