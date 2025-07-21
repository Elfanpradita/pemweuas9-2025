<?php

namespace App\Filament\Admin\Resources\KeranjangResource\Pages;

use App\Filament\Admin\Resources\KeranjangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeranjangs extends ListRecords
{
    protected static string $resource = KeranjangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
