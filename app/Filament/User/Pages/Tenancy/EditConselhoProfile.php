<?php

namespace App\Filament\User\Pages\Tenancy;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditConselhoProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Dados do Conselho';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                                TextInput::make('nome')
                                    ->label('Nome do Conselho')
                                    ->required()
                                    ->columnSpan(4)
                                    ->maxLength(255),
                                FileUpload::make('logotipo')
                                    ->label('Logotipo')
                                    ->image()
                                    ->disk('public')
                                    ->visibility('public')
                                    ->directory('logotipos')
                                    ->maxParallelUploads(1)
                                    ->previewable(false)
                                    ->uploadingMessage('Anexando arquivo...')
                                    ->columnSpan(2)
                                    ->panelLayout('compact')
                                    ->panelAspectRatio('8:1'),
                                TextInput::make('endereco')
                                    ->label('Endereço')
                                    ->columnSpan(4)
                                    ->maxLength(255),
                                TextInput::make('telefone')
                                    ->label('Telefone')
                                    ->tel()
                                    ->columnSpan(2)
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->label('E-mail Público')
                                    ->email()
                                    ->columnSpan(6)
                                    ->maxLength(255),

                                TextInput::make('facebook')
                                    ->label('Link do Facebook')
                                    ->url()
                                    ->columnSpan(3)
                                    ->maxLength(255),
                                TextInput::make('instagram')
                                    ->label('Link do Instagram')
                                    ->url()
                                    ->columnSpan(3)
                                    ->maxLength(255),
                    ])->columns(6),
            ]);
    }
}
