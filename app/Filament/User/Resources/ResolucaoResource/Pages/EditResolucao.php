<?php
namespace App\Filament\User\Resources\ResolucaoResource\Pages;
use App\Filament\User\Resources\ResolucaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditResolucao extends EditRecord
{
    protected static string $resource = ResolucaoResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}