<?php
namespace App\Filament\User\Resources\PautaResource\Pages;
use App\Filament\User\Resources\PautaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListPautas extends ListRecords
{
    protected static string $resource = PautaResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}