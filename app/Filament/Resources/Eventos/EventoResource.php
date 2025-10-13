<?php

namespace App\Filament\Resources\Eventos;

use App\Filament\Resources\Eventos\Pages\CreateEvento;
use App\Filament\Resources\Eventos\Pages\EditEvento;
use App\Filament\Resources\Eventos\Pages\ListEventos;
use App\Filament\Resources\Eventos\Pages\ViewEvento;
use App\Filament\Resources\Eventos\Schemas\EventoForm;
use App\Filament\Resources\Eventos\Schemas\EventoInfolist;
use App\Filament\Resources\Eventos\Tables\EventosTable;
use App\Models\Evento;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventoResource extends Resource
{
    protected static ?string $model = Evento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Evento';

    public static function form(Schema $schema): Schema
    {
        return EventoForm::configure($schema);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->selectRaw('
            tb_eventos.*,
            (SELECT fMoeda(sum(price)) FROM tb_eventos_inscritos where situacao = 3 and evento = tb_eventos.id) as VlrInscPG,
            (SELECT count(*) FROM tb_eventos_inscritos where situacao in (85, 3, 93) and evento = tb_eventos.id) as Atletas
            ')

            ->with(['organizadorModel:id,nome', 'organizadorModel.configuracao:id,pagseguro_email']);
    }

    public static function table(Table $table): Table
    {
        return EventosTable::configure($table);
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
            'index' => ListEventos::route('/'),
            'create' => CreateEvento::route('/create'),
            'view' => ViewEvento::route('/{record}'),
            'edit' => EditEvento::route('/{record}/edit'),
        ];
    }
}
