<?php

namespace App\Filament\Resources\AreaPublicidades;

use App\Filament\Resources\AreaPublicidades\Pages\CreateAreaPublicidade;
use App\Filament\Resources\AreaPublicidades\Pages\EditAreaPublicidade;
use App\Filament\Resources\AreaPublicidades\Pages\ListAreaPublicidades;
use App\Filament\Resources\AreaPublicidades\Schemas\AreaPublicidadeForm;
use App\Filament\Resources\AreaPublicidades\Tables\AreaPublicidadesTable;
use App\Models\AreaPublicidade;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AreaPublicidadeResource extends Resource
{
    protected static ?string $model = AreaPublicidade::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Área de publicidade';
    protected static ?string $label = 'Área de publicidade';

    public static function form(Schema $schema): Schema
    {
        return AreaPublicidadeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AreaPublicidadesTable::configure($table);
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
            'index' => ListAreaPublicidades::route('/'),
            'create' => CreateAreaPublicidade::route('/create'),
            'edit' => EditAreaPublicidade::route('/{record}/edit'),
        ];
    }
}
