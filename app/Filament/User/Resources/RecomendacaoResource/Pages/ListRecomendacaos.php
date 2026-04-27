<?php
namespace App\Filament\User\Resources\RecomendacaoResource\Pages;
use App\Filament\User\Resources\RecomendacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListRecomendacaos extends ListRecords
{
    protected static string $resource = RecomendacaoResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}