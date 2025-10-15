<?php

namespace App\Filament\Resources\Usuarios;

use App\Filament\Resources\Eventos\RelationManagers\InscricoesRelationManager;
use App\Filament\Resources\Usuarios\Pages\CreateUsuario;
use App\Filament\Resources\Usuarios\Pages\EditUsuario;
use App\Filament\Resources\Usuarios\Pages\ListUsuarios;
use App\Filament\Resources\Usuarios\Pages\ViewUsuario;
use App\Filament\Resources\Usuarios\Schemas\UsuarioForm;
use App\Filament\Resources\Usuarios\Schemas\UsuarioInfolist;
use App\Filament\Resources\Usuarios\Tables\UsuariosTable;
use App\Models\Usuario;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UsuarioResource extends Resource
{
    protected static ?string $model = Usuario::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::User;

    protected static ?string $recordTitleAttribute = 'Usuário';

    public static function form(Schema $schema): Schema
    {
        return UsuarioForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsuariosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            InscricoesRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsuarios::route('/'),
            'create' => CreateUsuario::route('/create'),
            'view' => ViewUsuario::route('/{record}'),
            'edit' => EditUsuario::route('/{record}/edit'),
        ];
    }
}
