<?php

namespace App\Filament\Resources\ReciboResource\Pages;

use App\Filament\Resources\ReciboResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRecibos extends ListRecords
{
    protected static string $resource = ReciboResource::class;

    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        $user = auth()->user();

        // Fiscal: solo ve pendientes
        if ($user->isRevisoraFiscal()) {
            return $query->where('estado', 'pendiente');
        }

        // Caja: solo ve aprobados
        if ($user->isCaja()) {
            return $query->where('estado', 'aprobado');
        }

        // Coordinador o admins: ven todo
        return $query;
    }
}
