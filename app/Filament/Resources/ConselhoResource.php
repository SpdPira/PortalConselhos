<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConselhoResource\Pages;
use App\Models\Conselho;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ConselhoResource extends Resource
{
    protected static ?string $model = Conselho::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $modelLabel = 'Conselho';
    protected static ?string $pluralModelLabel = 'Conselhos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('descricao')
                    ->label('Descrição')
                    ->maxLength(65535),
                Forms\Components\FileUpload::make('logotipo')
                    ->image()
                    ->directory('logotipos'),
                Forms\Components\TextInput::make('endereco')
                    ->label('Endereço')
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefone')
                    ->label('Telefone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logotipo'),
                Tables\Columns\TextColumn::make('nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefone'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConselhos::route('/'),
            'create' => Pages\CreateConselho::route('/create'),
            'edit' => Pages\EditConselho::route('/{record}/edit'),
        ];
    }
}
