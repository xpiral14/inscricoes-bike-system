<?php

namespace App\Filament\Resources\Eventos\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;

class InscricoesRelationManager extends RelationManager
{
    protected static string $relationship = 'inscricoes';


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                             Select::make('situacao')
                                 ->label('Situação')
                                 ->options([
                                               94 => 'Aguardando Pagamento',
                                               1  => 'Aguardando Pagamento',
                                               7  => 'Cancelado pelo PagSeguro',
                                               5  => 'Comprador Solicitou Valor de Volta',
                                               93 => 'Cortesia',
                                               9  => 'Inscrito(a)',
                                               85 => 'Marcado como Pago',
                                               3  => 'Pago',
                                               2  => 'Pagto em Análise',
                                               18 => 'Prazo Pagto Esgotado',
                                               70 => 'Reembolso Organizador',
                                               75 => 'Transferido para outro evento',
                                               6  => 'Valor Devolvido',
                                           ])
                                 ->required(),


                             TextInput::make('camisa')
                                 ->label('Camisa')
                                 ->maxLength(45),


                             Select::make('categoryID')
                                 ->label('Categoria')
                                 ->preload()
                                 ->searchable()
                                 ->relationship('categoria', 'name', fn($query, $record) => $query->where('event', $record->evento))
                             ,


                             TextInput::make('price')
                                 ->label('Preço')
                                 ->currencyMask('.', ',')
                                 ->numeric()
                                 ->prefix('R$'),


                             TextInput::make('paymentNetAmount')
                                 ->label('Valor Final')
                                 ->currencyMask('.', ',')
                                 ->numeric()
                                 ->prefix('R$'),


                             DateTimePicker::make('datalimite')
                                 ->label('Data Limite'),
                         ])->columns(2);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                             TextEntry::make('usuario')
                                 ->numeric(),
                             TextEntry::make('datacad')
                                 ->dateTime(),
                             TextEntry::make('datalimite')
                                 ->dateTime(),
                             TextEntry::make('situacao')
                                 ->numeric(),
                             TextEntry::make('dataconfirm')
                                 ->dateTime(),
                             TextEntry::make('priceId')
                                 ->numeric(),
                             TextEntry::make('categoryID')
                                 ->numeric(),
                             TextEntry::make('price')
                                 ->money(),
                             TextEntry::make('paymentType')
                                 ->numeric(),
                             TextEntry::make('paymentSubtype')
                                 ->numeric(),
                             TextEntry::make('paymentInstallments')
                                 ->numeric(),
                             TextEntry::make('paymentNetAmount')
                                 ->numeric(),
                             TextEntry::make('camisa'),
                             TextEntry::make('camisaId')
                                 ->numeric(),
                             TextEntry::make('chaveComent'),
                             TextEntry::make('origem')
                                 ->numeric(),
                             TextEntry::make('seguro')
                                 ->numeric(),
                             TextEntry::make('vlrSeguro')
                                 ->numeric(),
                             TextEntry::make('infomarkpaid'),
                             TextEntry::make('vlrlib')
                                 ->numeric(),
                             TextEntry::make('opcionais')
                                 ->numeric(),
                             TextEntry::make('emailenviado')
                                 ->numeric(),
                             TextEntry::make('kitenviado')
                                 ->numeric(),
                             TextEntry::make('dtkitenviado')
                                 ->dateTime(),
                             TextEntry::make('comissaobruta')
                                 ->numeric(),
                             TextEntry::make('divulgadorID')
                                 ->numeric(),
                             TextEntry::make('chave2')
                                 ->numeric(),
                             TextEntry::make('cupomDesc')
                                 ->numeric(),
                             TextEntry::make('pctDesconto')
                                 ->numeric(),
                             TextEntry::make('vlrDisponivel')
                                 ->numeric(),
                             TextEntry::make('dtVlrDisponivel')
                                 ->dateTime(),
                             TextEntry::make('releaseDate')
                                 ->dateTime(),
                         ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Inscrição')
            ->modifyQueryUsing(fn(Builder $query) => $query->with(['usuarioModel', 'situacaoModel', 'categoria']))
            ->columns([
                          TextColumn::make('usuarioModel.nome')
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

                      ])
            ->recordActions([
                                ViewAction::make(),
                                EditAction::make(),
                                DeleteAction::make(),
                            ])
            ->toolbarActions([
                                 BulkActionGroup::make([
                                                           DissociateBulkAction::make(),
                                                           DeleteBulkAction::make(),
                                                       ]),
                             ]);
    }
}
