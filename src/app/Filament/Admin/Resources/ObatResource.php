<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\Obat;
use App\Models\Toko;
use Filament\Tables;
use App\Models\Apoteker;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\ObatResource\Pages;

class ObatResource extends Resource
{
    protected static ?string $model = Obat::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube'; // ikon lebih relevan
    protected static ?string $navigationLabel = 'Daftar Obat';
    protected static ?string $pluralModelLabel = 'Obat';
    protected static ?string $modelLabel = 'Obat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('toko_id')
                    ->label('Toko')
                    ->relationship('toko', 'nama')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('nama_obat')
                    ->label('Nama Obat')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('harga')
                    ->label('Harga')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('stok')
                    ->label('Stok')
                    ->numeric()
                    ->required(),

                Forms\Components\Select::make('apoteker_id')
                    ->label('Apoteker')
                    ->relationship('apoteker', 'nama_lengkap')
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('toko.nama')
                    ->label('Toko')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama_obat')
                    ->label('Nama Obat')
                    ->searchable(),

                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('apoteker.nama_lengkap')
                    ->label('Apoteker'),

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
            'index' => Pages\ListObats::route('/'),
            'create' => Pages\CreateObat::route('/create'),
            'edit' => Pages\EditObat::route('/{record}/edit'),
        ];
    }
}
