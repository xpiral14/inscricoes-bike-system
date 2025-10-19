<?php

namespace App\Filament\Resources\EventoCupoms\Tables;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventoCupomTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                fn($query) => $query->with(['criador', 'usuario'])
            )
            ->recordTitleAttribute('Cupom')
            ->columns([
                          TextColumn::make('codigoCupom')
                              ->label('Código')
                              ->searchable(),
                          TextColumn::make('desconto')
                              ->numeric()
                              ->sortable(),
                          TextColumn::make('quantidade')
                              ->numeric()
                              ->sortable(),
                          TextColumn::make('usuario.nome')
                              ->label('Usado por')
                              ->numeric()
                              ->sortable(),
                          TextColumn::make('datacad')
                              ->dateTime()
                              ->sortable(),
                          TextColumn::make('criador.nome')
                              ->numeric()
                              ->sortable(),
                      ])
            ->filters([
                          //
                      ])
            ->headerActions([
                                CreateAction::make(),
                            ])
            ->recordActions([
                                EditAction::make(),
                                DeleteAction::make(),
                            ])
            ->toolbarActions([
                                 BulkActionGroup::make([
                                                           DeleteBulkAction::make(),
                                                       ]),
                             ]);
    }
}
