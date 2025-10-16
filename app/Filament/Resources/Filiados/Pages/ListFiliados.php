<?php

namespace App\Filament\Resources\Filiados\Pages;

use App\Filament\Resources\Filiados\FiliadoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFiliados extends ListRecords
{
    protected static string $resource = FiliadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
