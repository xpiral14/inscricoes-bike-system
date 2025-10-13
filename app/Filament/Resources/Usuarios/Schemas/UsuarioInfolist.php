<?php

namespace App\Filament\Resources\Usuarios\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UsuarioInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('tipo')
                    ->numeric(),
                TextEntry::make('nome'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('senha'),
                TextEntry::make('salt'),
                TextEntry::make('email_confirmado')
                    ->numeric(),
                TextEntry::make('datacad')
                    ->dateTime(),
                TextEntry::make('email_checkstring'),
                TextEntry::make('session_date')
                    ->dateTime(),
                TextEntry::make('tentativas_erradas')
                    ->numeric(),
                TextEntry::make('imagem'),
                TextEntry::make('datasenha')
                    ->dateTime(),
                TextEntry::make('telefone'),
                TextEntry::make('cidade'),
                TextEntry::make('estado'),
                TextEntry::make('data_nascimento')
                    ->dateTime(),
                TextEntry::make('hashh'),
                TextEntry::make('data_confirmacao')
                    ->dateTime(),
                TextEntry::make('cpf'),
                TextEntry::make('uf'),
                TextEntry::make('primeiroevento')
                    ->numeric(),
                TextEntry::make('email_recover'),
                TextEntry::make('useragent')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('screenwidth')
                    ->numeric(),
                TextEntry::make('ipregistro'),
                TextEntry::make('instagram'),
                TextEntry::make('sexo'),
                TextEntry::make('numerocbc'),
                TextEntry::make('nomeequipe'),
                TextEntry::make('nomepai'),
                TextEntry::make('nomemae'),
                TextEntry::make('endereco'),
                TextEntry::make('rg'),
                TextEntry::make('bairro'),
                TextEntry::make('cep'),
                TextEntry::make('sangue'),
                TextEntry::make('categoria'),
                TextEntry::make('naturalidade'),
                TextEntry::make('altura'),
                TextEntry::make('tcalcado'),
                TextEntry::make('tagasalho'),
                TextEntry::make('tcamiseta'),
                TextEntry::make('tshort'),
                TextEntry::make('creditos')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('evtbike')
                    ->numeric(),
                TextEntry::make('evtcorrida')
                    ->numeric(),
                TextEntry::make('dtCadastroAtualizado')
                    ->dateTime(),
                TextEntry::make('apelido'),
                TextEntry::make('filiado2024')
                    ->numeric(),
                TextEntry::make('qtdEventos')
                    ->numeric(),
            ]);
    }
}
