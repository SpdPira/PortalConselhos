<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublishedFileResource\Pages;
use App\Models\PublishedFile;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class PublishedFileResource extends Resource
{
    protected static ?string $model = PublishedFile::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $modelLabel = 'Auditoria de Arquivo';

    protected static ?string $pluralModelLabel = 'Auditoria de Arquivos';
    
    protected static string|UnitEnum|null $navigationGroup = 'Auditoria';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('file_name')
                    ->label('Nome do Arquivo')
                    ->maxLength(255),
                Forms\Components\TextInput::make('file_size')
                    ->label('Tamanho (Bytes)')
                    ->numeric(),
                Forms\Components\TextInput::make('mime_type')
                    ->label('Tipo (MIME)')
                    ->maxLength(255),
                Forms\Components\TextInput::make('file_hash')
                    ->label('Hash SHA-256')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ip_address')
                    ->label('Endereço IP')
                    ->maxLength(255),
                Forms\Components\KeyValue::make('meta_data')
                    ->label('Metadados')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('file_name')
                    ->label('Arquivo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('publishable_type')
                    ->label('Modelo')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('action')
                    ->label('Ação')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('file_size')
                    ->label('Tamanho')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mime_type')
                    ->label('MIME')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePublishedFiles::route('/'),
        ];
    }
}
