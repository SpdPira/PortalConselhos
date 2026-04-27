<?php
namespace App\Filament\User\Resources\ReuniaoExtraordinariaResource\Pages;
use App\Filament\User\Resources\ReuniaoExtraordinariaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Assunto;
class CreateReuniaoExtraordinaria extends CreateRecord
{
    protected static string $resource = ReuniaoExtraordinariaResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_assunto'] = Assunto::where('descricao', 'Reuniões Extraordinárias')->first()->id;
        return $data;
    }
}