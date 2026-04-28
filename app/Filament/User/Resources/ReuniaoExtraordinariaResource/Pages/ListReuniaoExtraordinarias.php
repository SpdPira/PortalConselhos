<?php
namespace App\Filament\User\Resources\ReuniaoExtraordinariaResource\Pages;
use App\Filament\User\Resources\ReuniaoExtraordinariaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListReuniaoExtraordinarias extends ListRecords
{
    protected static string $resource = ReuniaoExtraordinariaResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label(__('Cadastrar Reunião Extraordinária'))];
    }
}