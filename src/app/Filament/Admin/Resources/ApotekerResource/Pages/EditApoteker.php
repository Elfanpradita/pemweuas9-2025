<?php

namespace App\Filament\Admin\Resources\ApotekerResource\Pages;

use App\Filament\Admin\Resources\ApotekerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApoteker extends EditRecord
{
    protected static string $resource = ApotekerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
