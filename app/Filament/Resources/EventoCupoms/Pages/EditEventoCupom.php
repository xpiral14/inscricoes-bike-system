<?php

namespace App\Filament\Resources\EventoCupoms\Pages;

use App\Filament\Resources\EventoCupoms\EventoCupomResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEventoCupom extends EditRecord
{
    protected static string $resource = EventoCupomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
