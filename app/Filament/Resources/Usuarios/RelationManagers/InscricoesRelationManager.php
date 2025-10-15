<?php

namespace App\Filament\Resources\Usuarios\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InscricoesRelationManager extends RelationManager
{
    protected static string $relationship = 'inscricoes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('evento')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('datacad')
                    ->required(),
                DateTimePicker::make('datalimite')
                    ->required(),
                TextInput::make('situacao')
                    ->required()
                    ->numeric()
                    ->default(9),
                DateTimePicker::make('dataconfirm')
                    ->required(),
                TextInput::make('priceId')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('categoryID')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
                TextInput::make('paymentType')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('paymentSubtype')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('paymentInstallments')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('paymentNetAmount')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('camisa')
                    ->required(),
                TextInput::make('camisaId')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('chaveComent')
                    ->required(),
                TextInput::make('origem')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('seguro')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('vlrSeguro')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('infomarkpaid')
                    ->required(),
                TextInput::make('vlrlib')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('opcionais')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('emailenviado')
                    ->email()
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('kitenviado')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('dtkitenviado')
                    ->required(),
                TextInput::make('comissaobruta')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('divulgadorID')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('chave2')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('cupomDesc')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('pctDesconto')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('vlrDisponivel')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('dtVlrDisponivel')
                    ->required(),
                DateTimePicker::make('releaseDate')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Inscrição')
            ->columns([
                TextColumn::make('evento')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('datacad')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('datalimite')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('situacao')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dataconfirm')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('priceId')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('categoryID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('price')
                    ->money()
                    ->sortable(),
                TextColumn::make('paymentType')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('paymentSubtype')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('paymentInstallments')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('paymentNetAmount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('camisa')
                    ->searchable(),
                TextColumn::make('camisaId')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('chaveComent')
                    ->searchable(),
                TextColumn::make('origem')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('seguro')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vlrSeguro')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('infomarkpaid')
                    ->searchable(),
                TextColumn::make('vlrlib')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('opcionais')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('emailenviado')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('kitenviado')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dtkitenviado')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('comissaobruta')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('divulgadorID')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('chave2')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cupomDesc')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pctDesconto')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vlrDisponivel')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dtVlrDisponivel')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('releaseDate')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
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
