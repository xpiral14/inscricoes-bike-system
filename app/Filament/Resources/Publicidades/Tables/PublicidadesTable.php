<?php

namespace App\Filament\Resources\Publicidades\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PublicidadesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with(['area']))
            ->defaultSort('id', 'desc')
            ->columns([
                          TextColumn::make('nm_titulo')
                              ->label('Título')
                              ->searchable(),
                          TextColumn::make('ds_link')
                              ->label('Link')
                              ->searchable(),
                          TextColumn::make('area.nm_nome')
                              ->numeric()
                              ->sortable(),
                          ImageColumn::make('ds_imagem')
                              ->disk('public')
                              ->getStateUsing(fn($record) => str_replace('..', '', $record->ds_imagem)),
                          TextColumn::make('nu_largura')
                              ->numeric()
                              ->sortable(),
                          TextColumn::make('nu_altura')
                              ->numeric()
                              ->sortable(),
                          TextColumn::make('fl_ativo')
                              ->numeric()
                              ->sortable(),
                      ])
            ->filters([
                          //
                      ])
            ->recordActions([
                                EditAction::make(),
                            ])
            ->toolbarActions([
                                 BulkActionGroup::make([
                                                           DeleteBulkAction::make(),
                                                       ]),
                             ]);
    }
}
