<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\ReuniaoExtraordinariaResource\Pages;
use App\Models\Calendario;
use App\Models\Assunto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReuniaoExtraordinariaResource extends Resource
{
    protected static ?string $model = Calendario::class;
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $modelLabel = 'Reuniões Extraordinárias';
    protected static ?string $pluralModelLabel = 'Reuniões Extraordinárias';
    protected static ?string $slug = 'reuniaoextraordinarias';

    public static function form(Form $form): Form
    {
        return $form
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
