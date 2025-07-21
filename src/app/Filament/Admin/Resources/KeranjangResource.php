<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\Obat;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Keranjang;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\KeranjangResource\Pages;

class KeranjangResource extends Resource
{
    protected static ?string $model = Keranjang::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Keranjang Belanja';
    protected static ?string $pluralModelLabel = 'Keranjang';
    protected static ?string $modelLabel = 'Keranjang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Pengguna')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('obat_id')
                    ->label('Obat')
                    ->relationship('obat', 'nama')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('qty')
                    ->label('Jumlah')
                    ->required()
                    ->numeric()
                    ->minValue(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable(),

                Tables\Columns\TextColumn::make('obat.nama')
                    ->label('Obat')
                    ->searchable(),

                Tables\Columns\TextColumn::make('qty')
                    ->label('Jumlah')
                    ->sortable(),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeranjangs::route('/'),
            'create' => Pages\CreateKeranjang::route('/create'),
            'edit' => Pages\EditKeranjang::route('/{record}/edit'),
        ];
    }
}
