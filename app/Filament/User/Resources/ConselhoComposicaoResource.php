<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\ConselhoComposicaoResource\Pages;
use App\Models\ConselhoComposicao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConselhoComposicaoResource extends Resource
{
    protected static ?string $model = ConselhoComposicao::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'Membro da Diretoria';
    protected static ?string $pluralModelLabel = 'Membros da Diretoria';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('funcao')
                    ->label('Função')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('segmento')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('vigencia_inicio')
                    ->label('Vigência Inicial')
                    ->required(),
                Forms\Components\DatePicker::make('vigencia_fim')
                    ->label('Vigência Final')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('funcao')
                    ->label('Função')
                    ->searchable(),
                Tables\Columns\TextColumn::make('segmento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vigencia_inicio')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('vigencia_fim')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConselhoComposicaos::route('/'),
            'create' => Pages\CreateConselhoComposicao::route('/create'),
            'edit' => Pages\EditConselhoComposicao::route('/{record}/edit'),
        ];
    }
}
