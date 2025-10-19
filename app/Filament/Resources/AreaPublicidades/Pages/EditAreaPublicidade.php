<?php

namespace App\Filament\Resources\AreaPublicidades\Pages;

use App\Filament\Resources\AreaPublicidades\AreaPublicidadeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAreaPublicidade extends EditRecord
{
    protected static string $resource = AreaPublicidadeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
