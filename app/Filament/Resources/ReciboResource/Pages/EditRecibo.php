<?php

namespace App\Filament\Resources\ReciboResource\Pages;

use App\Filament\Resources\ReciboResource;
use Filament\Resources\Pages\EditRecord;

class EditRecibo extends EditRecord
{
    protected static string $resource = ReciboResource::class;

    protected function authorizeAccess(): void
    {
        $user = auth()->user();

        if (!($user->isCoordinador() || $user->isRevisoraFiscal() || $user->isCaja())) {
            abort(403);
        }
    }
}
