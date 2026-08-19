<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\AtaResource\Pages;
use App\Models\Assunto;
use App\Models\Calendario;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AtaResource extends Resource
{
    protected static ?string $model = Calendario::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $modelLabel = 'Ata';
    protected static ?string $pluralModelLabel = 'Atas';
    protected static ?string $slug = 'atas';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\TextInput::make('descricao')
                            ->label('Título do Documento')
                            ->columnSpan(6)
                            ->required(),
                        Forms\Components\DatePicker::make('data')
                            ->label('Data')
                            ->columnSpan(3)
                            ->required(),
                        Forms\Components\FileUpload::make('arquivo')
                            ->label('Anexar Ata')
                            ->acceptedFileTypes(['application/pdf'])
                            ->disk('public')
                            ->visibility('public')
                            ->directory('atas')
                            ->maxParallelUploads(1)
                            ->previewable(false)
                            ->uploadingMessage('Anexando arquivo...')
                            ->columnSpan(3)
                            ->panelLayout('compact')
                            ->panelAspectRatio('12:1'),
                    ])->columns(6),
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
                    ->url(fn($record) => $record->arquivo ? \Illuminate\Support\Facades\Storage::url($record->arquivo) : null)
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
