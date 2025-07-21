<?php

namespace App\Filament\Admin\Resources\ApotekerResource\Pages;

use App\Filament\Admin\Resources\ApotekerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApotekers extends ListRecords
{
    protected static string $resource = ApotekerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
