<?php

namespace App\Filament\Resources\Filiados\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FiliadosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->searchable(),
                TextColumn::make('cpf')
                    ->searchable(),
                TextColumn::make('filiacao')
                    ->searchable(),
                TextColumn::make('categoria')
                    ->searchable(),
                TextColumn::make('ano')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cidade')
                    ->searchable(),
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
