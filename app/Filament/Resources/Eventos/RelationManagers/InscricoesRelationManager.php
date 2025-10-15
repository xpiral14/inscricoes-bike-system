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
    protected static ?string $label = 'Inscrição';
    protected static ?string $title = 'Inscrições';
    protected static ?string $pluralLabel = 'Inscrições';


    public function form(Schema $schema): Schema
    {
        return EventoInscritoForm::configure($schema);
    }


    public function table(Table $table): Table
    {
        EventoInscritosTable::configure($table);

        $table->modifyQueryUsing(fn(Builder $query) => $query->with(['usuarioModel', 'situacaoModel', 'categoria', 'eventoModel']));
        $columns = $table->getColumns();
        array_shift($columns);
        array_unshift($columns, TextColumn::make('eventoModel.titulo')->label('Evento')->sortable());
        $table->columns($columns)->defaultSort('datacad', 'desc');
        return $table;

    }
}
