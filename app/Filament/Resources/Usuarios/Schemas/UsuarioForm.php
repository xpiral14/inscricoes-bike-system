<?php

namespace App\Filament\Resources\Usuarios\Schemas;

use Filament\Forms\Components\DatePicker; // Alterado de DateTimePicker para DatePicker para data_nascimento
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select; // Adicionado para campos tipo Select
use Filament\Schemas\Schema;

class UsuarioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            // Define o formulário principal para ter 2 colunas
            ->columns(2)
            ->components([
                             // 1. Nome (col-sm-6 no HTML, ocupa 1 coluna inteira no layout 2x2)
                             TextInput::make('nome')
                                 ->required()
                                 ->columnSpanFull(), // Ocupa as 2 colunas

                             // 2. Email
                             TextInput::make('email')
                                 ->label('E-mail') // Rótulo como no HTML
                                 ->email()
                                 ->required(),

                             // 3. Tipo (Select)
                             Select::make('tipo')
                                 ->label('Tipo')
                                 ->options([
                                               1 => 'Usuário',
                                               2 => 'Organizador',
                                               5 => 'Gerente Master',
                                           ])
                                 ->required(),

                             // 4. Telefone
                             TextInput::make('telefone')
                                 ->tel()
                                 ->mask('(99) 99999-9999') // Máscara de telefone, se necessário
                                 ->required(),

                             // 5. CPF
                             TextInput::make('cpf')
                                 ->label('CPF')
                                 ->mask('999.999.999-99') // Máscara de CPF
                                 ->required(),

                             // 6. Data Nasc (Usando DatePicker, pois é apenas data no HTML)
                             DatePicker::make('data_nascimento')
                                 ->label('Data Nasc')
                                 ->required(),

                             // 7. Sexo (Select)
                             Select::make('sexo')
                                 ->label('Sexo')
                                 ->options([
                                               'M' => 'Masculino',
                                               'F' => 'Feminino',
                                           ])
                                 ->required(),

                             // 8. Situação E-mail (email_confirmado) (Select)
                             Select::make('email_confirmado')
                                 ->label('Situação E-mail')
                                 ->options([
                                               0 => 'Não Confirmado',
                                               1 => 'Confirmado',
                                               9 => 'Não Existe',
                                           ])
                                 ->required(),

                             // 9. Cidade
                             TextInput::make('cidade')
                                 ->required(),

                             // 10. UF
                             TextInput::make('uf')
                                 ->label('UF')
                                 ->required(),

                             // 11. Equipe (nomeequipe)
                             TextInput::make('nomeequipe')
                                 ->label('Equipe')
                                 ->required(),

                             // 12. Número CBC
                             TextInput::make('numerocbc')
                                 ->label('Número CBC')
                                 ->required(),

                             // 13. IP Registro (col-sm-12 no HTML, ocupa 2 colunas inteiras)
                             TextInput::make('ipregistro')
                                 ->label('Ip Registro')
                                 ->required()
                                 ->columnSpanFull(),

                             // 14. Navegador (useragent) (col-sm-12 no HTML, ocupa 2 colunas inteiras)
                             Textarea::make('useragent')
                                 ->label('Navegador')
                                 ->rows(4) // Ajuste a altura
                                 ->columnSpanFull(),

                             // --- CAMPO OCULTO/AVANÇADO ---
                             // Ocultamos os campos técnicos (senha, salt, etc.) que não aparecem no HTML.
                             // Se precisar deles, adicione-os de volta, talvez em um Section::make('Dados Técnicos')->collapsed()

                             TextInput::make('senha')->hidden(),
                             TextInput::make('salt')->hidden(),
                             TextInput::make('email_checkstring')->hidden(),
                             TextInput::make('hashh')->hidden(),
                             TextInput::make('imagem')->hidden(),
                             TextInput::make('primeiroevento')->hidden(),
                             TextInput::make('email_recover')->hidden(),
                             Textarea::make('creditos')->hidden(),
                             // ... (e outros campos técnicos que não estavam no HTML)
                         ]);
    }
}
