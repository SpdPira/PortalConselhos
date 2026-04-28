<?php
namespace App\Filament\User\Resources\ReuniaoOrdinariaResource\Pages;
use App\Filament\User\Resources\ReuniaoOrdinariaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListReuniaoOrdinarias extends ListRecords
{
    protected static string $resource = ReuniaoOrdinariaResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label(__('Cadastrar Reunião Ordinária'))];
    }
}