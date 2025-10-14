<?php

namespace App\Filament\Resources\EventoInscritos\Pages;

use App\Filament\Resources\EventoInscritos\EventoInscritoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEventoInscrito extends EditRecord
{
    protected static string $resource = EventoInscritoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
