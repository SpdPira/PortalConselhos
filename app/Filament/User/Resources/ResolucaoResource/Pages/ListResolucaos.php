<?php
namespace App\Filament\User\Resources\ResolucaoResource\Pages;
use App\Filament\User\Resources\ResolucaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListResolucaos extends ListRecords
{
    protected static string $resource = ResolucaoResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}