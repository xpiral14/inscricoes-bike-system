<?php

namespace App\Filament\Resources\EventoInscritos\Pages;

use App\Filament\Resources\EventoInscritos\EventoInscritoResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEventoInscrito extends ViewRecord
{
    protected static string $resource = EventoInscritoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
