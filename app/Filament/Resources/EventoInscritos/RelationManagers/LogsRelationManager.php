<?php

namespace App\Filament\Resources\EventoInscritos\RelationManagers;

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
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LogsRelationManager extends RelationManager
{
    protected static string $relationship = 'logs';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('ds_log')
                    ->columnSpanFull(),
                DateTimePicker::make('dt_data'),
                TextInput::make('cod_situacao'),
                TextInput::make('tipo_pg')
                    ->required(),
                TextInput::make('subtipo_pg')
                    ->required(),
                TextInput::make('parcelas_pg')
                    ->required(),
                TextInput::make('valorliquido_pg')
                    ->required(),
                TextInput::make('paytag')
                    ->required(),
                TextInput::make('nomecpf')
                    ->required(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ds_log')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('dt_data')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('cod_situacao')
                    ->placeholder('-'),
                TextEntry::make('tipo_pg'),
                TextEntry::make('subtipo_pg'),
                TextEntry::make('parcelas_pg'),
                TextEntry::make('valorliquido_pg'),
                TextEntry::make('paytag'),
                TextEntry::make('nomecpf'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Log')
            ->columns([
                TextColumn::make('dt_data')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('cod_situacao')
                    ->searchable(),
                TextColumn::make('tipo_pg')
                    ->searchable(),
                TextColumn::make('subtipo_pg')
                    ->searchable(),
                TextColumn::make('parcelas_pg')
                    ->searchable(),
                TextColumn::make('valorliquido_pg')
                    ->searchable(),
                TextColumn::make('paytag')
                    ->searchable(),
                TextColumn::make('nomecpf')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
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
