<?php
namespace App\Filament\User\Resources\LegislacaoResource\Pages;
use App\Filament\User\Resources\LegislacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditLegislacao extends EditRecord
{
    protected static string $resource = LegislacaoResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}