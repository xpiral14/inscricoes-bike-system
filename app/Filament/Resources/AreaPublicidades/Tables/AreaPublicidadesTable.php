<?php

namespace App\Filament\Resources\AreaPublicidades\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AreaPublicidadesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nm_nome')
                    ->label('Nome')
                    ->searchable(),
                TextColumn::make('nu_largura')
                    ->label('Largura')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nu_altura')
                    ->label('Altura')
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
