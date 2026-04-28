<?php
namespace App\Filament\User\Resources\LegislacaoResource\Pages;
use App\Filament\User\Resources\LegislacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListLegislacaos extends ListRecords
{
    protected static string $resource = LegislacaoResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label(__('Incluir Legislação'))];
    }
}