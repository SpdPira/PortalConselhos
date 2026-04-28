<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CalendarioResource\Pages;
use App\Models\Calendario;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CalendarioResource extends Resource
{
    protected static ?string $model = Calendario::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $modelLabel = 'Registro Global';
    protected static ?string $pluralModelLabel = 'Registros Globais';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('id_conselho')
                    ->relationship('conselho', 'nome')
                    ->required(),
                Forms\Components\Select::make('id_assunto')
                    ->relationship('assunto', 'descricao')
                    ->required(),
                Forms\Components\TextInput::make('descricao')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('data')
                    ->required(),
                Forms\Components\TimePicker::make('hora'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('conselho.nome')
                    ->label('Conselho')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('assunto.descricao')
                    ->label('Assunto')
                    ->sortable(),
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('conselho')
                    ->relationship('conselho', 'nome'),
                Tables\Filters\SelectFilter::make('assunto')
                    ->relationship('assunto', 'descricao'),
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
            'index' => Pages\ListCalendarios::route('/'),
            'create' => Pages\CreateCalendario::route('/create'),
            'edit' => Pages\EditCalendario::route('/{record}/edit'),
        ];
    }
}
