<?php

namespace App\Filament\Resources\ReciboResource\Pages;

use App\Filament\Resources\ReciboResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecibo extends EditRecord
{
    protected static string $resource = ReciboResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
