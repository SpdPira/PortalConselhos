<?php
namespace App\Filament\User\Resources\PautaResource\Pages;
use App\Filament\User\Resources\PautaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditPauta extends EditRecord
{
    protected static string $resource = PautaResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}