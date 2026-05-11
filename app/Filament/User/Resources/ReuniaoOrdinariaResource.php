<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\ReuniaoOrdinariaResource\Pages;
use App\Models\Assunto;
use App\Models\Calendario;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReuniaoOrdinariaResource extends Resource
{
    protected static ?string $model = Calendario::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Reunião Ordinária';
    protected static ?string $pluralModelLabel = 'Reuniões Ordinárias';
    protected static ?string $slug = 'reuniaoordinarias';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\TextInput::make('descricao')
                            ->label('Título da Reunião')
                            ->columnSpan(6)
                            ->required(),
                        DatePicker::make('data')
                            ->label('Data')
                            ->columnSpan(1)
                            ->required(),
                        TimePicker::make('hora')
                            ->label('Hora')
                            ->columnSpan(1)
                            ->required(),
                        Forms\Components\FileUpload::make('arquivo')
                            ->label('Anexar Pauta')
                            ->acceptedFileTypes(['application/pdf'])
                            ->disk('public')
                            ->visibility('public')
                            ->directory('pautas')
                            ->maxParallelUploads(1)
                            ->previewable(false)
                            ->uploadingMessage('Anexando arquivo...')
                            ->columnSpan(4)
                            ->panelLayout('compact')
                            ->panelAspectRatio('16:1'),
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
            $q->where('descricao', 'Reuniões Ordinárias');
        });
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReuniaoOrdinarias::route('/'),
            'create' => Pages\CreateReuniaoOrdinaria::route('/create'),
            'edit' => Pages\EditReuniaoOrdinaria::route('/{record}/edit'),
        ];
    }
}
