<?php

namespace App\Filament\Resources\WasherResource\Pages;

use App\Filament\Resources\WasherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWasher extends EditRecord
{
    protected static string $resource = WasherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
