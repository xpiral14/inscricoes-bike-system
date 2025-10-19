<?php

namespace App\Filament\Resources\AreaPublicidades\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AreaPublicidadeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                             TextInput::make('nm_nome')
                                 ->label('Nome')
                                 ->required(),
                             TextInput::make('nu_largura')
                                 ->required()
                                 ->label('largura')
                                 ->numeric()
                                 ->default(0),
                             TextInput::make('nu_altura')
                                 ->label('altura')
                                 ->required()
                                 ->numeric()
                                 ->default(0),
                         ]);
    }
}
