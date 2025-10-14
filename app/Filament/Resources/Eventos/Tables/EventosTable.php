<?php

namespace App\Filament\Resources\Eventos\Tables;

use App\Models\Evento;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Query\Builder;

class EventosTable
{

    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('dataevento', 'desc')
            ->columns([
                          TextColumn::make('id')
                              ->label('ID')
                              ->sortable(),

                          ImageColumn::make('banner')
                              ->label('Banner'),

                          TextColumn::make('active')
                              ->badge()
                              ->label('Situação')
                              ->color(fn($state) => match($state) {
                                  0 => 'Bloqueado',
                                  1 => 'No Ar',
                                  2 => 'Não Listado',
                                  default => 'Desconhecido',
                              })
                              ->formatStateUsing(fn($state): string => match ((int)$state) {
                                  0       => 'Bloqueado',
                                  1       => 'No Ar',
                                  2       => 'Não Listado',
                                  default => 'Desconhecido',
                              })
                              ->weight(fn($state): string => ((int)$state === 1) ? 'bold' : 'normal'),

                          TextColumn::make('organizadorModel.nome')
                          ->label('Organizador')
                              ->html()
                              ->formatStateUsing(function (Evento $record) {
                                  $organizadorNome = $record->organizadorModel->nome ?? 'Não informado';
                                  // Acessando a configuração através da relação aninhada
                                  $pagseguroEmail = $record->organizadorModel?->configuracao?->pagseguro_email ?? '';
                                  return "$organizadorNome<br/>PagSeguro: $pagseguroEmail";
                              })
                              ->searchable(query: function (Builder $query, string $search): Builder {
                                  return $query->whereHas('organizadorModel', function ($q) use ($search) {
                                      $q->where('nome', 'like', "%{$search}%");
                                  });
                              }),

                          TextColumn::make('dataevento')
                              ->label('Data')
                              ->dateTime('d/m/Y')
                              ->formatStateUsing(fn(Evento $record) => $record->dataevento->format('d/m/Y') . ' ' . $record->horaevento)
                              ->sortable(),

                          TextColumn::make('qtdinscritos')
                              ->label('Inscritos')
                              ->numeric()
                              ->sortable(),

                          TextColumn::make('Atletas')
                              ->label('Atletas')
                              ->numeric(),

                          TextColumn::make('urlcompleta')
                              ->label('URL')
                              ->html()
                              ->formatStateUsing(fn($state) => '<a href="' . url($state) . '" target="_blank">Ver Evento</a>'),

                          // Representando &#x1f455; (👕) com um ícone
                          IconColumn::make('escolhercamisas')
                              ->label('Camisa')
                              ->boolean()
                              ->trueIcon('heroicon-o-user-circle') // Ícone sugestivo para camisa
                              ->falseIcon(''),

                          // Representando &#x2713; (✓) com um ícone do Filament
                          IconColumn::make('permitirinscricao')
                              ->label('Permit. Inscr.')
                              ->boolean()
                              ->trueIcon('heroicon-o-check-circle')
                              ->falseIcon('heroicon-o-x-circle')
                              ->trueColor('success')
                              ->falseColor('danger'),

                          TextColumn::make('VlrInscPG')
                              ->label('Vlr. Insc. PG')
                              ->money('BRL'),

                          TextColumn::make('vlrLIberado')
                              ->label('Vlr. Lib. PS')
                              ->money('BRL'),

                          TextColumn::make('netValue')
                              ->label('Vlr. Rec. PS')
                              ->money('BRL'),

                          TextColumn::make('vlrpago')
                              ->label('Vlr. Pago ao Org.')
                              ->money('BRL'),

                          TextColumn::make('valorPagotaxas')
                              ->label('Vlr. Pago Taxas')
                              ->money('BRL'),

                          TextColumn::make('qtdPgCartao')
                              ->label('Pg. Cartão')
                              ->numeric(),
                      ])
            ->filters([
                          //
                      ])
            ->filters([
                          //
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
