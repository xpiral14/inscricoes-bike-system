<?php

namespace App\Filament\Resources\EventoInscritos;

use App\Filament\Resources\EventoInscritos\Pages\CreateEventoInscrito;
use App\Filament\Resources\EventoInscritos\Pages\EditEventoInscrito;
use App\Filament\Resources\EventoInscritos\Pages\ListEventoInscritos;
use App\Filament\Resources\EventoInscritos\Pages\ViewEventoInscrito;
use App\Filament\Resources\EventoInscritos\Schemas\EventoInscritoForm;
use App\Filament\Resources\EventoInscritos\Schemas\EventoInscritoInfolist;
use App\Filament\Resources\EventoInscritos\Tables\EventoInscritosTable;
use App\Models\EventoInscrito;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventoInscritoResource extends Resource
{
    protected static ?string $model = EventoInscrito::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Inscrição';
    protected static ?string $label = 'Inscrição';
    protected static ?string $pluralLabel = 'Inscrições';

    public static function form(Schema $schema): Schema
    {
        return EventoInscritoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventoInscritoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        EventoInscritosTable::configure($table)
            ->modifyQueryUsing(fn(Builder $query) => $query->with(['usuarioModel', 'situacaoModel', 'categoria', 'eventoModel']))
            ->defaultSort('datacad', 'desc');
        $columns = $table->getColumns();
        $filters = $table->getFilters();

        array_unshift($columns, TextColumn::make('eventoModel.titulo'));
        array_unshift(
            $filters, SelectFilter::make('eventoModel')
            ->relationship('EventoModel', 'titulo')
            ->searchable()
            ->label('Evento')
        );
        $table->columns($columns);
        $table->filters($filters);
        return $table;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListEventoInscritos::route('/'),
            'create' => CreateEventoInscrito::route('/create'),
            'view'   => ViewEventoInscrito::route('/{record}'),
            //'edit' => EditEventoInscrito::route('/{record}/edit'),
        ];
    }
}
