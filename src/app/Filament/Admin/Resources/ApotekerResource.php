<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\Toko;
use App\Models\User;
use Filament\Tables;
use App\Models\Apoteker;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\ApotekerResource\Pages;

class ApotekerResource extends Resource
{
    protected static ?string $model = Apoteker::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group'; // ikon diganti lebih relevan

    protected static ?string $navigationLabel = 'Daftar Apoteker';

    protected static ?string $pluralModelLabel = 'Apoteker';
    protected static ?string $modelLabel = 'Apoteker';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('toko_id')
                    ->label('Toko')
                    ->relationship('toko', 'nama')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->required(),

                Forms\Components\Select::make('manager_id')
                    ->label('Manager')
                    ->relationship('manager', 'nama_lengkap')
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),

                Tables\Columns\TextColumn::make('toko.nama')
                    ->label('Toko')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable(),

                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin'),

                Tables\Columns\TextColumn::make('manager.nama_lengkap')
                    ->label('Manager'),

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
            // tambahkan RelationManagers jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListApotekers::route('/'),
            'create' => Pages\CreateApoteker::route('/create'),
            'edit' => Pages\EditApoteker::route('/{record}/edit'),
        ];
    }
}
