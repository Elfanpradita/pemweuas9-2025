<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\Toko;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Transaksi;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\TransaksiResource\Pages;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?string $navigationLabel = 'Daftar Transaksi';
    protected static ?string $pluralModelLabel = 'Transaksi';
    protected static ?string $modelLabel = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Pengguna')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('toko_id')
                    ->label('Toko')
                    ->relationship('toko', 'nama')
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('total')
                    ->label('Total')
                    ->required()
                    ->numeric(),

                Forms\Components\Select::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'expired' => 'Expired',
                    ])
                    ->required(),

                Forms\Components\Select::make('metode_pengiriman')
                    ->label('Metode Pengiriman')
                    ->options([
                        'ambil' => 'Ambil di Toko',
                        'antar' => 'Antar ke Alamat',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('alamat_pengiriman')
                    ->label('Alamat Pengiriman')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('biaya_ongkir')
                    ->label('Biaya Ongkir')
                    ->numeric()
                    ->default(null),

                Forms\Components\Select::make('status_pengiriman')
                    ->label('Status Pengiriman')
                    ->options([
                        'belum dikirim' => 'Belum Dikirim',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                        'gagal' => 'Gagal',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('midtrans_order_id')
                    ->label('Midtrans Order ID')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable(),

                Tables\Columns\TextColumn::make('toko.nama')
                    ->label('Toko')
                    ->searchable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed', 'expired' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('metode_pengiriman')
                    ->label('Pengiriman'),

                Tables\Columns\TextColumn::make('biaya_ongkir')
                    ->label('Ongkir')
                    ->numeric(),

                Tables\Columns\TextColumn::make('status_pengiriman')
                    ->label('Status Kirim'),

                Tables\Columns\TextColumn::make('midtrans_order_id')
                    ->label('Midtrans ID')
                    ->searchable(),

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
            // Tambah relation manager jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
