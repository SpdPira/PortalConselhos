<?php
namespace App\Filament\User\Resources\RecomendacaoResource\Pages;
use App\Filament\User\Resources\RecomendacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Assunto;
class CreateRecomendacao extends CreateRecord
{
    protected static string $resource = RecomendacaoResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_assunto'] = Assunto::where('descricao', 'Recomendações')->first()->id;
        return $data;
    }
}