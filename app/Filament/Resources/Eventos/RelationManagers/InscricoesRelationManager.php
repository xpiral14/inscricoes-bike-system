<?php

namespace App\Filament\Resources\Eventos\RelationManagers;

use App\Filament\Resources\EventoInscritos\Schemas\EventoInscritoForm;
use App\Filament\Resources\EventoInscritos\Tables\EventoInscritosTable;
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
        return EventoInscritoForm::configure($schema);
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
        return EventoInscritosTable::configure($table);
    }
}
