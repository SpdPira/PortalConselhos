<?php

namespace App\Filament\User\Pages\Tenancy;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;

class EditConselhoProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Dados do Conselho';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome')
                    ->label('Nome do Conselho')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('logotipo')
                    ->label('Logotipo')
                    ->image()
                    ->directory('logotipos'),
                TextInput::make('endereco')
                    ->label('Endereço')
                    ->maxLength(255),
                TextInput::make('telefone')
                    ->label('Telefone')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('E-mail Público')
                    ->email()
                    ->maxLength(255),
                TextInput::make('facebook')
                    ->label('Link do Facebook')
                    ->url()
                    ->maxLength(255),
                TextInput::make('instagram')
                    ->label('Link do Instagram')
                    ->url()
                    ->maxLength(255),
            ]);
    }
}
