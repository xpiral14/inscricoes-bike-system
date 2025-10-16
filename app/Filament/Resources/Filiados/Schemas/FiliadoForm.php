<?php

namespace App\Filament\Resources\Filiados\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FiliadoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nome')
                    ->required(),
                TextInput::make('cpf')
                    ->mask('999.999.999-99')
                    ->required(),
                TextInput::make('filiacao')
                    ->required(),
                TextInput::make('categoria')
                    ->required(),
                TextInput::make('ano')
                    ->required()
                    ->numeric()
                    ->default(2024),
                TextInput::make('cidade')
                    ->required(),
            ]);
    }
}
