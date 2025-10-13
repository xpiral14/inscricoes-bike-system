<?php

namespace App\Filament\Resources\Eventos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
                                       // --- Seção de Informações Básicas ---
                                       TextInput::make('titulo')
                                           ->label('Título')
                                           ->required()
                                           ->maxLength(80),

                                       TextInput::make('videoyoutube')
                                           ->label('Código Vídeo Youtube')
                                           ->maxLength(150)
                                           ->default(' ')
                                           ->required(),

                                       Select::make('organizador')
                                           ->label('Organizador')
                                           ->relationship('organizadorModel', 'nome')
                                           ->searchable()
                                           ->required(),

                                       // --- Seção de Valores e Configurações de Taxas ---
                                       Select::make('seguro')
                                           ->label('Seguro?')
                                           ->options([
                                                         0 => 'Sem Seguro',
                                                         1 => 'Obrigatório',
                                                         2 => 'Opcional',
                                                     ])
                                           ->default(0) // Seu HTML mostra '1' selecionado, ajustei o default para o valor real
                                           ,

                                       TextInput::make('vlrSeguro')
                                           ->label('Vlr Seguro')
                                           ->prefix('R$')
                                           ->currencyMask('.', ',')
                                           ->default('0,00')
                                           ,

                                       Select::make('taxaconv')
                                           ->label('Tx Conv?')
                                           ->options([
                                                         0 => 'Sem Taxa',
                                                         1 => 'Com Taxa',
                                                     ])
                                           ->default(0)
                                           ,

                                       TextInput::make('vlrTaxaConv')
                                           ->label('Vlr Tx Conv.')
                                           ->prefix('R$')
                                           ->currencyMask('.', ',')
                                           ->default('0,00')
                                           ,

                                       TextInput::make('valorfrete')
                                           ->label('Valor Frete')
                                           ->prefix('R$')
                                           ->currencyMask('.', ',')
                                           ->default('0,00')
                                           ,

                                       // --- Seção de Logística e Opções ---
                                       Select::make('exportarendereco')
                                           ->label('Exportar Endereço')
                                           ->options([
                                                         0 => 'Não',
                                                         1 => 'Sim',
                                                     ])
                                           ->default(0)
                                           ,

                                       Select::make('escolhercamisas')
                                           ->label('Escolher Camisas?')
                                           ->required()
                                           ->options([
                                                         0 => 'Não',
                                                         1 => 'Sim',
                                                     ])
                                           ->default(0)
                                           ,

                                       Select::make('ocultarValorCategorias')
                                           ->label('Ocultar Valor Cat?')
                                           ->options([
                                                         0 => 'Não',
                                                         1 => 'Sim',
                                                     ])
                                           ->default(0)
                                           ,

                                       Select::make('importarFiliados')
                                           ->label('Import Filiados? (Criar 1º Cupom Antes)')
                                           ->options([
                                                         0 => 'Não',
                                                         1 => 'Sim',
                                                     ])
                                           ->default(0)
                                           ,

                                       // --- Seção de Comissões (Campos 'obrigatorios' no HTML) ---
                                       TextInput::make('comissaopagos')
                                           ->label('Comiss. Pagos')
                                           ->required()
                                           ->prefix('R$')
                                           ->currencyMask('.', ',')
                                           ->default('0,00')
                                           ,

                                       TextInput::make('comissaomarcados')
                                           ->label('Comiss. Marcados Pag')
                                           ->required()
                                           ->prefix('R$')
                                           ->currencyMask('.', ',')
                                           ->default('0,00')
                                           ,

                                       TextInput::make('comissaocortesia')
                                           ->label('Comiss. Cortesia')
                                           ->required()
                                           ->prefix('R$')
                                           ->currencyMask('.', ',')
                                           ->default('0,00')
                                           ,

                                       TextInput::make('comissaoreembolsoorg')
                                           ->label('Comiss. Reembolso Organiz')
                                           ->required()
                                           ->prefix('R$')
                                           ->currencyMask('.', ',')
                                           ->default('0,00')
                                           ,

                                       TextInput::make('comissaotransferidoevento')
                                           ->label('Comiss. Transf. out evt')
                                           ->required()
                                           ->prefix('R$')
                                           ->currencyMask('.', ',')
                                           ->default('0,00')
                                           ,

                                       TextInput::make('comissaodivulgador')
                                           ->label('Comiss. Divulgador')
                                           ->prefix('R$')
                                           ->currencyMask('.', ',')
                                           ->default('0,00')
                                           ,

                                       TextInput::make('custoseguro')
                                           ->label('Valor Seguro Unitário')
                                           ->required()
                                           ->prefix('R$')
                                           ->currencyMask('.', ',')
                                           ->default('0,00')
                                           ,

                                       // O seu HTML usava um Select para o booleano aqui, mas um Toggle é mais idiomático no Filament
                                       Toggle::make('descontartaxasdoliquido')
                                           ->label('Descontar Taxas do Líquido?')
                                           ->default(true)
                                           ,

                                       // --- Seção de Horários ---
                                       TextInput::make('horaevento')
                                           ->label('Hora Inicial; Ex: 7:00')
                                           ->placeholder('HH:MM')
                                           ->mask('99:99') // Usa máscara para formato de hora
                                           ->maxLength(5)
                                           ,

                                       TextInput::make('horafinalprovavel')
                                           ->label('Hora Final provavel (Oculto, Google); Ex: 14:00')
                                           ->placeholder('HH:MM')
                                           ->mask('99:99')
                                           ->maxLength(5)
                                           ,

                                       TextInput::make('horafinal')
                                           ->label('Hora Final (Visível site); Ex: 14:00')
                                           ->placeholder('HH:MM')
                                           ->mask('99:99')
                                           ->maxLength(5)
                                           ,

                                       // --- Seção de Textos Longos ---
                                       Textarea::make('infopagamento')
                                           ->label('Info Pagamento para depósito')
                                           ->columnSpanFull()
                                           ->rows(3),

                                       Textarea::make('mapa')
                                           ->label('Mapa')
                                           ->columnSpanFull()
                                           ->rows(5)
                                           ,

                                   ]);
    }
}
