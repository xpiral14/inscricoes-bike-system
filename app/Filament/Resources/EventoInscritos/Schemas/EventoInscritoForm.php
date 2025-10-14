<?php

namespace App\Filament\Resources\EventoInscritos\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EventoInscritoForm
{
    public static function configure(Schema $schema): Schema
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
}
