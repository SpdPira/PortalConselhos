<?php

namespace App\Filament\User\Resources;

use Filament\Schemas\Schema;

use App\Filament\User\Resources\LegislacaoResource\Pages;
use App\Models\Assunto;
use App\Models\Calendario;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;

use Filament\Resources\Resource;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LegislacaoResource extends Resource
{
    protected static ?string $model = Calendario::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $modelLabel = 'Legislação';
    protected static ?string $pluralModelLabel = 'Legislação';
    protected static ?string $slug = 'legislacaos';

    public static function form(Schema $schema): Schema
    {
        return $schema
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
