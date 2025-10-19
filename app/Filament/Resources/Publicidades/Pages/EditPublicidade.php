<?php

namespace App\Filament\Resources\Publicidades\Pages;

use App\Filament\Resources\Publicidades\PublicidadeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPublicidade extends EditRecord
{
    protected static string $resource = PublicidadeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
