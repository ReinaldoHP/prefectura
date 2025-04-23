<?php

namespace App\Filament\Resources\ReciboResource\Pages;

use App\Filament\Resources\ReciboResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRecibo extends CreateRecord
{
    protected static string $resource = ReciboResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(auth()->user()?->isCoordinador(), 403);
    }
}
