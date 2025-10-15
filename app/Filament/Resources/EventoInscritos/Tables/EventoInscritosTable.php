<?php

namespace App\Filament\Resources\EventoInscritos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter; // Adicionar esta importação

class EventoInscritosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Inscrição')
            ->modifyQueryUsing(fn(Builder $query) => $query->with(['usuarioModel', 'situacaoModel', 'categoria']))
            ->columns([
                          TextColumn::make('usuarioModel.nome')
                              ->label('Nome')
                              ->numeric()
                              ->sortable(),
                          TextColumn::make('datacad')
                              ->label('Data de inscrição')
                              ->dateTime()
                              ->sortable(),
                          TextColumn::make('datalimite')
                              ->label('Data limite')
                              ->dateTime()
                              ->sortable(),
                          TextColumn::make('situacaoModel.nome')
                              ->label('Situação')
                              ->numeric()
                              ->sortable(),
                          TextColumn::make('categoria.name')
                              ->limit(50)
                              ->sortable(),
                          TextColumn::make('price')
                              ->label('Valor')
                              ->getStateUsing(fn($record) => $record->price * 100)
                              ->currency('BRL'),
                          TextColumn::make('paymentNetAmount')
                              ->label('Valor final')
                              ->getStateUsing(fn($record) => $record->paymentNetAmount * 100)
                              ->currency('BRL'),
                          TextColumn::make('Taxas')
                              ->getStateUsing(fn($record) => $record->paymentNetAmount ? round((1.0 - ($record->paymentNetAmount / $record->price)) * 100, 2) : 0)
                              ->suffix('%')
                          ,
                          TextColumn::make('paymentInstallments')
                              ->label('Parcelas')
                              ->numeric()
                              ->default(0),
                          TextColumn::make('camisa')
                              ->searchable(),
                          TextColumn::make('origem')
                              ->getStateUsing(fn($record) => match ($record->origem) {
                                  1       => 'Cadastro',
                                  2       => 'Login',
                                  3       => 'Reativação',
                                  default => 'Outros',
                              }),
                      ])
            ->filters([
                          // Adicionando o filtro de situações usando o relacionamento
                          SelectFilter::make('situacaoModel')
                              ->relationship('situacaoModel', 'nome')
                              ->label('Situação'),
                      ])
            ->recordActions([
                                ViewAction::make(),
                                EditAction::make(),
                            ])
            ->toolbarActions([
                                 BulkActionGroup::make([
                                                           DeleteBulkAction::make(),
                                                       ]),
                             ]);
    }
}
