<?php

namespace App\Filament\Resources\Filiados;

use App\Filament\Resources\Filiados\Pages\CreateFiliado;
use App\Filament\Resources\Filiados\Pages\EditFiliado;
use App\Filament\Resources\Filiados\Pages\ListFiliados;
use App\Filament\Resources\Filiados\Schemas\FiliadoForm;
use App\Filament\Resources\Filiados\Tables\FiliadosTable;
use App\Models\Filiado;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FiliadoResource extends Resource
{
    protected static ?string $model = Filiado::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Filiado';

    public static function form(Schema $schema): Schema
    {
        return FiliadoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FiliadosTable::configure($table);
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
            'index' => ListFiliados::route('/'),
            'create' => CreateFiliado::route('/create'),
            'edit' => EditFiliado::route('/{record}/edit'),
        ];
    }
}
