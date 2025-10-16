<?php

namespace App\Filament\Resources\Filiados\Pages;

use App\Filament\Resources\Filiados\FiliadoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFiliado extends EditRecord
{
    protected static string $resource = FiliadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
