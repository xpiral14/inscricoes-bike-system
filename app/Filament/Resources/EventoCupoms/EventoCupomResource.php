<?php

namespace App\Filament\Resources\EventoCupoms;

use App\Filament\Resources\EventoCupoms\Pages\CreateEventoCupom;
use App\Filament\Resources\EventoCupoms\Pages\EditEventoCupom;
use App\Filament\Resources\EventoCupoms\Pages\ListEventoCupoms;
use App\Filament\Resources\EventoCupoms\Schemas\EventoCupomForm;
use App\Filament\Resources\EventoCupoms\Tables\EventoCupomTable;
use App\Models\EventoCupom;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EventoCupomResource extends Resource
{
    protected static ?string $model = EventoCupom::class;
    protected static ?string $label = 'Cupom de evento';
    protected static ?string $pluralLabel = 'Cupom de eventos';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ShoppingBag;

    protected static ?string $recordTitleAttribute = 'EventoCupom';

    public static function form(Schema $schema): Schema
    {
        return EventoCupomForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventoCupomTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventoCupoms::route('/'),
            'create' => CreateEventoCupom::route('/create'),
            'edit' => EditEventoCupom::route('/{record}/edit'),
        ];
    }
}
