<?php
namespace App\Filament\User\Resources\AtaResource\Pages;
use App\Filament\User\Resources\AtaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Assunto;
class CreateAta extends CreateRecord
{
    protected static string $resource = AtaResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_assunto'] = Assunto::where('descricao', 'Atas')->first()->id;
        return $data;
    }
}