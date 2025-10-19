<?php

namespace App\Filament\Resources\Publicidades\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Image;
use Filament\Schemas\Schema;

class PublicidadeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                             TextInput::make('nm_titulo')
                                 ->label('Título'),
                             TextInput::make('ds_link')
                                 ->label('Link'),
                             Select::make('cd_area')
                                 ->relationship('area', 'nm_nome')
                                 ->required()
                             ,
                             FileUpload::make('ds_imagem')->formatStateUsing(fn($record) => str_replace('..', '', $record?->ds_imagem ?? ''))
                                 ->disk('public')
                                 ->directory('/publicidades'),
                             Textarea::make('ds_script')
                                 ->label('script')
                                 ->columnSpanFull(),
                             TextInput::make('nu_largura')
                                 ->label('Largura')
                                 ->required()
                                 ->numeric()
                                 ->default(0),
                             TextInput::make('nu_altura')
                                 ->label('Altura')
                                 ->required()
                                 ->numeric()
                                 ->default(0),
                             Toggle::make('fl_ativo')
                                 ->label('Ativo')
                                 ->default(1),
                         ]);
    }
}
