<?php
namespace App\Filament\User\Resources\ResolucaoResource\Pages;
use App\Filament\User\Resources\ResolucaoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Assunto;
class CreateResolucao extends CreateRecord
{
    protected static string $resource = ResolucaoResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_assunto'] = Assunto::where('descricao', 'Resoluções')->first()->id;
        return $data;
    }
}