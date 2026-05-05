<?php

namespace App\Filament\User\Resources;

use Filament\Schemas\Schema;

use App\Filament\User\Resources\ResolucaoResource\Pages;
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

class ResolucaoResource extends Resource
{
    protected static ?string $model = Calendario::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-scale';
    protected static ?string $modelLabel = 'Resolução';
    protected static ?string $pluralModelLabel = 'Resoluções';
    protected static ?string $slug = 'resolucaos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('descricao')->label('Título do Documento')->required(),
                Forms\Components\DatePicker::make('data')->label('Data')->required(),
                Forms\Components\FileUpload::make('arquivo')
                    ->label('Anexar Resolução')
                    ->acceptedFileTypes(['application/pdf'])
                    ->disk('public')
                    ->visibility('public')
                    ->directory('resolucoes')
                    ->openable()
                    ->downloadable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('descricao')->label('Descrição')->searchable(),
                Tables\Columns\TextColumn::make('data')->date('d/m/Y')->sortable(),
                Tables\Columns\IconColumn::make('arquivo')
                    ->label('Anexo')
                    ->icon('heroicon-o-document-text')
                    ->color('primary')
                    ->url(fn ($record) => $record->arquivo ? \Illuminate\Support\Facades\Storage::url($record->arquivo) : null)
                    ->openUrlInNewTab(),
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
            $q->where('descricao', 'Resoluções');
        });
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResolucaos::route('/'),
            'create' => Pages\CreateResolucao::route('/create'),
            'edit' => Pages\EditResolucao::route('/{record}/edit'),
        ];
    }
}
