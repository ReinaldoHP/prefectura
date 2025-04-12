<?php

namespace App\Filament\Resources\ReciboResource\Pages;

use App\Filament\Resources\ReciboResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecibos extends ListRecords
{
    protected static string $resource = ReciboResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
