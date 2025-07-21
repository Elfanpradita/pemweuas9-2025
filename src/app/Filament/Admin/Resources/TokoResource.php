<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\Toko;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Admin\Resources\TokoResource\Pages;

class TokoResource extends Resource
{
    protected static ?string $model = Toko::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'Daftar Toko';
    protected static ?string $pluralModelLabel = 'Toko';
    protected static ?string $modelLabel = 'Toko';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Toko')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('logo')
                    ->label('URL Logo (Opsional)')
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\TextInput::make('address')
                    ->label('Alamat')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Toko')
                    ->searchable()
                    ->sortable(),

                ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular()
                    ->height(40),

                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tambahkan filter di sini kalau perlu
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Tambahkan RelationManagers jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTokos::route('/'),
            'create' => Pages\CreateToko::route('/create'),
            'edit' => Pages\EditToko::route('/{record}/edit'),
        ];
    }
}
