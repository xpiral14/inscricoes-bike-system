<?php

namespace App\Filament\Resources\AreaPublicidades\Pages;

use App\Filament\Resources\AreaPublicidades\AreaPublicidadeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAreaPublicidades extends ListRecords
{
    protected static string $resource = AreaPublicidadeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
