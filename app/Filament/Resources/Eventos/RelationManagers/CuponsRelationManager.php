<?php

namespace App\Filament\Resources\Eventos\RelationManagers;

use App\Filament\Resources\EventoCupoms\EventoCupomResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class CuponsRelationManager extends RelationManager
{
    protected static string $relationship = 'cupons';

    protected static ?string $relatedResource = EventoCupomResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
