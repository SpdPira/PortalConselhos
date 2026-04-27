<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\AtaResource\Pages;
use App\Models\Calendario;
use App\Models\Assunto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AtaResource extends Resource
{
    protected static ?string $model = Calendario::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $modelLabel = 'Atas';
    protected static ?string $pluralModelLabel = 'Atas';
    protected static ?string $slug = 'atas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('descricao')->label('Título do Documento')->required(),
                Forms\Components\DatePicker::make('data')->label('Data de Publicação')->required(),
                // Anexos requires a relationship or field
        
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('descricao')->label('Descrição')->searchable(),
                Tables\Columns\TextColumn::make('data')->date('d/m/Y')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('assunto', function ($q) {
            $q->where('descricao', 'Atas');
        });
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAtas::route('/'),
            'create' => Pages\CreateAta::route('/create'),
            'edit' => Pages\EditAta::route('/{record}/edit'),
        ];
    }
}
