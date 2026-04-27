<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\LegislacaoResource\Pages;
use App\Models\Calendario;
use App\Models\Assunto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LegislacaoResource extends Resource
{
    protected static ?string $model = Calendario::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $modelLabel = 'Legislação';
    protected static ?string $pluralModelLabel = 'Legislação';
    protected static ?string $slug = 'legislacaos';

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
            $q->where('descricao', 'Legislação');
        });
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLegislacaos::route('/'),
            'create' => Pages\CreateLegislacao::route('/create'),
            'edit' => Pages\EditLegislacao::route('/{record}/edit'),
        ];
    }
}
