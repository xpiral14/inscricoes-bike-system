<?php

namespace App\Filament\Resources\EventoCupoms\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventoCupomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                             Select::make('evento')
                                 ->relationship('evento', 'titulo')
                                 ->required()
                                 ->searchable()
                                 ->columnSpanFull()
                             ,
                             TextInput::make('codigoCupom')
                                 ->required(),
                             TextInput::make('desconto')
                                 ->prefix('%')
                                 ->required()
                                 ->numeric()
                                 ->maxValue(100)
                                 ->minValue(1)
                                 ->default(1),
                             TextInput::make('quantidade')
                                 ->required()
                                 ->numeric()
                                 ->default(1),
                             Select::make('usadoPor')
                                 ->relationship('usuario', 'nome')
                                 ->required()
                                 ->searchable(),
                             Select::make('criadopor')
                                 ->relationship('criador', 'nome')
                                 ->searchable()
                                 ->required(),
                         ]);
    }
}
