<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\ConselhoComposicaoResource\Pages;
use App\Models\ConselhoComposicao;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConselhoComposicaoResource extends Resource
{
    protected static ?string $model = ConselhoComposicao::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'Membros';
    protected static ?string $pluralModelLabel = 'Membros';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->columnSpan(4)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('funcao')
                            ->label('Função')
                            ->required()
                            ->columnSpan(2)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('segmento')
                            ->required()
                            ->columnSpan(2)
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('vigencia_inicio')
                            ->label('Vigência Inicial')
                            ->columnSpan(2)
                            ->required(),
                        Forms\Components\DatePicker::make('vigencia_fim')
                            ->label('Vigência Final')
                            ->columnSpan(2)
                            ->required(),
                    ])->columns(6),
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
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
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
