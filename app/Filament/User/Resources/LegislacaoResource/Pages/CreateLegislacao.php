<?php
namespace App\Filament\User\Resources\LegislacaoResource\Pages;
use App\Filament\User\Resources\LegislacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Assunto;
class CreateLegislacao extends CreateRecord
{
    protected static string $resource = LegislacaoResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_assunto'] = Assunto::where('descricao', 'Legislação')->first()->id;
        return $data;
    }
}