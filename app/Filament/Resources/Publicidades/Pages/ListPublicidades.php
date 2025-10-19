<?php

namespace App\Filament\Resources\Publicidades\Pages;

use App\Filament\Resources\Publicidades\PublicidadeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPublicidades extends ListRecords
{
    protected static string $resource = PublicidadeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
