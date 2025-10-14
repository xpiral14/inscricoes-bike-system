<?php

namespace App\Filament\Resources\EventoInscritos\Pages;

use App\Filament\Resources\EventoInscritos\EventoInscritoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventoInscritos extends ListRecords
{
    protected static string $resource = EventoInscritoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
