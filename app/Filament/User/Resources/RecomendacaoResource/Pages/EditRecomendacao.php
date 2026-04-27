<?php
namespace App\Filament\User\Resources\RecomendacaoResource\Pages;
use App\Filament\User\Resources\RecomendacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditRecomendacao extends EditRecord
{
    protected static string $resource = RecomendacaoResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}