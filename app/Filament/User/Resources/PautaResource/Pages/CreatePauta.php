<?php
namespace App\Filament\User\Resources\PautaResource\Pages;
use App\Filament\User\Resources\PautaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Assunto;
class CreatePauta extends CreateRecord
{
    protected static string $resource = PautaResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_assunto'] = Assunto::where('descricao', 'Pautas')->first()->id;
        return $data;
    }
}