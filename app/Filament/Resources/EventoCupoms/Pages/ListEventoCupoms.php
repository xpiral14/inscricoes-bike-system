<?php

namespace App\Filament\Resources\EventoCupoms\Pages;

use App\Filament\Resources\EventoCupoms\EventoCupomResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventoCupoms extends ListRecords
{
    protected static string $resource = EventoCupomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
