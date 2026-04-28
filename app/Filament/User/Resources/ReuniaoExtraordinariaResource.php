<?php

namespace App\Filament\User\Resources;

use Filament\Schemas\Schema;

use App\Filament\User\Resources\ReuniaoExtraordinariaResource\Pages;
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

class ReuniaoExtraordinariaResource extends Resource
{
    protected static ?string $model = Calendario::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-star';
    protected static ?string $modelLabel = 'Reunião Extraordinária';
    protected static ?string $pluralModelLabel = 'Reuniões Extraordinárias';
    protected static ?string $slug = 'reuniaoextraordinarias';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('descricao')->label('Título da Reunião')->required(),
                Forms\Components\DatePicker::make('data')->required(),
                Forms\Components\TimePicker::make('hora')->required(),
        
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
            $q->where('descricao', 'Reuniões Extraordinárias');
        });
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReuniaoExtraordinarias::route('/'),
            'create' => Pages\CreateReuniaoExtraordinaria::route('/create'),
            'edit' => Pages\EditReuniaoExtraordinaria::route('/{record}/edit'),
        ];
    }
}
