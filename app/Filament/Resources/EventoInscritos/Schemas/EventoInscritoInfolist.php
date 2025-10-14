<?php

namespace App\Filament\Resources\EventoInscritos\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EventoInscritoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('usuario')
                    ->numeric(),
                TextEntry::make('evento')
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
}
