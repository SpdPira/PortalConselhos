<?php
namespace App\Filament\User\Resources\ReuniaoOrdinariaResource\Pages;
use App\Filament\User\Resources\ReuniaoOrdinariaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Assunto;
class CreateReuniaoOrdinaria extends CreateRecord
{
    protected static string $resource = ReuniaoOrdinariaResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_assunto'] = Assunto::where('descricao', 'Reuniões Ordinárias')->first()->id;
        return $data;
    }
}