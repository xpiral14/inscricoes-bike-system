<?php

namespace App\Filament\Resources\Usuarios\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsuariosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tipo')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('nome')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('senha')
                    ->searchable(),
                TextColumn::make('salt')
                    ->searchable(),
                TextColumn::make('email_confirmado')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('datacad')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('email_checkstring')
                    ->searchable(),
                TextColumn::make('session_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('tentativas_erradas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('imagem')
                    ->searchable(),
                TextColumn::make('datasenha')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('telefone')
                    ->searchable(),
                TextColumn::make('cidade')
                    ->searchable(),
                TextColumn::make('estado')
                    ->searchable(),
                TextColumn::make('data_nascimento')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('hashh')
                    ->searchable(),
                TextColumn::make('data_confirmacao')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('cpf')
                    ->searchable(),
                TextColumn::make('uf')
                    ->searchable(),
                TextColumn::make('primeiroevento')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('email_recover')
                    ->searchable(),
                TextColumn::make('screenwidth')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ipregistro')
                    ->searchable(),
                TextColumn::make('instagram')
                    ->searchable(),
                TextColumn::make('sexo')
                    ->searchable(),
                TextColumn::make('numerocbc')
                    ->searchable(),
                TextColumn::make('nomeequipe')
                    ->searchable(),
                TextColumn::make('nomepai')
                    ->searchable(),
                TextColumn::make('nomemae')
                    ->searchable(),
                TextColumn::make('endereco')
                    ->searchable(),
                TextColumn::make('rg')
                    ->searchable(),
                TextColumn::make('bairro')
                    ->searchable(),
                TextColumn::make('cep')
                    ->searchable(),
                TextColumn::make('sangue')
                    ->searchable(),
                TextColumn::make('categoria')
                    ->searchable(),
                TextColumn::make('naturalidade')
                    ->searchable(),
                TextColumn::make('altura')
                    ->searchable(),
                TextColumn::make('tcalcado')
                    ->searchable(),
                TextColumn::make('tagasalho')
                    ->searchable(),
                TextColumn::make('tcamiseta')
                    ->searchable(),
                TextColumn::make('tshort')
                    ->searchable(),
                TextColumn::make('evtbike')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('evtcorrida')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dtCadastroAtualizado')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('apelido')
                    ->searchable(),
                TextColumn::make('filiado2024')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('qtdEventos')
                    ->numeric()
                    ->sortable(),
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
