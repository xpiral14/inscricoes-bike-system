<?php

namespace App\Filament\Resources\Publicidades;

use App\Filament\Resources\Publicidades\Pages\CreatePublicidade;
use App\Filament\Resources\Publicidades\Pages\EditPublicidade;
use App\Filament\Resources\Publicidades\Pages\ListPublicidades;
use App\Filament\Resources\Publicidades\Schemas\PublicidadeForm;
use App\Filament\Resources\Publicidades\Tables\PublicidadesTable;
use App\Models\Publicidade;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PublicidadeResource extends Resource
{
    protected static ?string $model = Publicidade::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Publicidade';

    public static function form(Schema $schema): Schema
    {
        return PublicidadeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PublicidadesTable::configure($table);
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
            'index' => ListPublicidades::route('/'),
            'create' => CreatePublicidade::route('/create'),
            'edit' => EditPublicidade::route('/{record}/edit'),
        ];
    }
}
