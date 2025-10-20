<?php

namespace App\Filament\Resources\Eventos\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;

// 👈 Adicionado o Repeater
use Filament\Forms\Components\Group;

// 👈 Adicionado o Group
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

                                       // --- 1. SEÇÃO: INFORMAÇÕES BÁSICAS ---
                                       Section::make('Informações Básicas')
                                           ->description('Título, Organizador e Mídia principal.')
                                           ->collapsible()
                                           ->columns(2)
                                           ->schema([
                                                        TextInput::make('titulo')
                                                            ->label('Título')
                                                            ->required()
                                                            ->maxLength(80)
                                                            ->columnSpanFull(),

                                                        Select::make('organizador')
                                                            ->label('Organizador')
                                                            ->relationship('organizadorModel', 'nome')
                                                            ->searchable()
                                                            ->required(),

                                                        Select::make('estruturas')
                                                            ->label('Estruturas')
                                                            ->multiple()
                                                            ->relationship('estruturas', 'name')
                                                            ->preload()
                                                        ,

                                                        TextInput::make('videoyoutube')
                                                            ->label('Código Vídeo Youtube')
                                                            ->maxLength(150)
                                                            ->default('_'),
                                                    ]),

                                       // --- 2. SEÇÃO: DATAS E LOGÍSTICA ---
                                       Section::make('Datas e Logística')
                                           ->description('Horários do evento e opções logísticas.')
                                           ->collapsible()
                                           ->columns(3)
                                           ->schema([
                                                        TextInput::make('localevento')
                                                            ->label('Concentração'),
                                                        TextInput::make('limiteinscritos')
                                                            ->label('Limite de inscrições pagas')
                                                            ->numeric()
                                                            ->minValue(1)
                                                            ->required()
                                                        ,
                                                        TextInput::make('horaevento')
                                                            ->label('Hora Inicial; Ex: 7:00')
                                                            ->placeholder('HH:MM')
                                                            ->mask('99:99')
                                                            ->maxLength(5),

                                                        TextInput::make('horafinalprovavel')
                                                            ->label('Hora Final provavel (Oculto, Google); Ex: 14:00')
                                                            ->placeholder('HH:MM')
                                                            ->mask('99:99')
                                                            ->maxLength(5),

                                                        TextInput::make('horafinal')
                                                            ->label('Hora Final (Visível site); Ex: 14:00')
                                                            ->placeholder('HH:MM')
                                                            ->mask('99:99')
                                                            ->maxLength(5),

                                                        Select::make('exportarendereco')
                                                            ->label('Exportar Endereço')
                                                            ->options([
                                                                          0 => 'Não',
                                                                          1 => 'Sim',
                                                                      ])
                                                            ->default(0),

                                                        Select::make('escolhercamisas')
                                                            ->label('Escolher Camisas?')
                                                            ->required()
                                                            ->options([
                                                                          0 => 'Não',
                                                                          1 => 'Sim',
                                                                      ])
                                                            ->default(0),

                                                        Select::make('importarFiliados')
                                                            ->label('Import Filiados? (Criar 1º Cupom Antes)')
                                                            ->options([
                                                                          0 => 'Não',
                                                                          1 => 'Sim',
                                                                      ])
                                                            ->default(0),
                                                        Select::make('kit')
                                                            ->label('Possui Kit?')
                                                            ->boolean('Sim', 'Não')
                                                    ]),

                                       // --- 3. SEÇÃO: CONFIGURAÇÕES DE VALORES ---
                                       Section::make('Configurações de Valores e Taxas')
                                           ->description('Valores de seguro, frete e visibilidade.')
                                           ->collapsible()
                                           ->columns(3)
                                           ->schema([
                                                        // Configuração de Seguro
                                                        Select::make('seguro')
                                                            ->label('Seguro?')
                                                            ->options([
                                                                          0 => 'Sem Seguro',
                                                                          1 => 'Obrigatório',
                                                                          2 => 'Opcional',
                                                                      ])
                                                            ->default(0),

                                                        TextInput::make('vlrSeguro')
                                                            ->label('Vlr Seguro')
                                                            ->prefix('R$')
                                                            ->currencyMask('.', ',')
                                                            ->default('0,00'),

                                                        TextInput::make('custoseguro')
                                                            ->label('Valor Seguro Unitário') // Mudei a ordem para agrupar seguro
                                                            ->required()
                                                            ->prefix('R$')
                                                            ->currencyMask('.', ',')
                                                            ->default('0,00'),

                                                        // Configuração de Frete
                                                        TextInput::make('valorfrete')
                                                            ->label('Valor Frete')
                                                            ->prefix('R$')
                                                            ->currencyMask('.', ',')
                                                            ->default('0,00'),

                                                        // Outras opções de valor
                                                        Select::make('ocultarValorCategorias')
                                                            ->label('Ocultar Valor Cat?')
                                                            ->options([
                                                                          0 => 'Não',
                                                                          1 => 'Sim',
                                                                      ])
                                                            ->default(0),
                                                    ]),

                                       // --- 4. SEÇÃO: COMISSÕES E TAXAS ADICIONAIS ---
                                       Section::make('Comissões e Taxas')
                                           ->description('Defina comissões para diferentes situações e taxas de convênio.')
                                           ->collapsed() // Colapsada por padrão para simplificar a visão inicial
                                           ->columns(4) // Usando 4 colunas para organizar melhor os campos de comissão
                                           ->schema([
                                                        // Taxa de Convênio
                                                        Select::make('taxaconv')
                                                            ->label('Tx Conv?')
                                                            ->options([
                                                                          0 => 'Sem Taxa',
                                                                          1 => 'Com Taxa',
                                                                      ])
                                                            ->default(0),

                                                        TextInput::make('vlrTaxaConv')
                                                            ->label('Vlr Tx Conv.')
                                                            ->prefix('R$')
                                                            ->currencyMask('.', ',')
                                                            ->default('0,00'),

                                                        // Toggle de Desconto (columnSpanFull para alinhar)
                                                        Toggle::make('descontartaxasdoliquido')
                                                            ->label('Descontar Taxas do Líquido?')
                                                            ->default(true)
                                                            ->columnSpanFull(),

                                                        // Comissões (todos requeridos no seu código original)
                                                        TextInput::make('comissaopagos')
                                                            ->label('Comiss. Pagos')
                                                            ->required()
                                                            ->prefix('R$')
                                                            ->currencyMask('.', ',')
                                                            ->default('0,00'),

                                                        TextInput::make('comissaomarcados')
                                                            ->label('Comiss. Marcados Pag')
                                                            ->required()
                                                            ->prefix('R$')
                                                            ->currencyMask('.', ',')
                                                            ->default('0,00'),

                                                        TextInput::make('comissaocortesia')
                                                            ->label('Comiss. Cortesia')
                                                            ->required()
                                                            ->prefix('R$')
                                                            ->currencyMask('.', ',')
                                                            ->default('0,00'),

                                                        TextInput::make('comissaoreembolsoorg')
                                                            ->label('Comiss. Reembolso Organiz')
                                                            ->required()
                                                            ->prefix('R$')
                                                            ->currencyMask('.', ',')
                                                            ->default('0,00'),

                                                        TextInput::make('comissaotransferidoevento')
                                                            ->label('Comiss. Transf. out evt')
                                                            ->required()
                                                            ->prefix('R$')
                                                            ->currencyMask('.', ',')
                                                            ->default('0,00'),

                                                        TextInput::make('comissaodivulgador')
                                                            ->label('Comiss. Divulgador')
                                                            ->prefix('R$')
                                                            ->currencyMask('.', ',')
                                                            ->default('0,00'),
                                                    ]),

                                       // --- 5. SEÇÃO: DETALHES E CONTEÚDO ---
                                       Section::make('Detalhes e Conteúdo')
                                           ->description('Descrições longas, mídias visuais')
                                           ->collapsible()
                                           ->schema([
                                                        RichEditor::make('descricao')
                                                            ->columnSpanFull()
                                                            ->toolbarButtons([
                                                                                 'attachFiles', 'blockquote', 'bold', 'bulletList', 'codeBlock', 'h2', 'h3', 'italic',
                                                                                 'link', 'orderedList', 'redo', 'strike', 'underline', 'undo',
                                                                             ]),

                                                        Textarea::make('infopagamento')
                                                            ->label('Info Pagamento para depósito')
                                                            ->rows(3)
                                                            ->columnSpanFull(),

                                                        Textarea::make('mapa')
                                                            ->label('Mapa')
                                                            ->rows(5)
                                                            ->columnSpanFull(),
                                                    ]),

                                       Section::make('Categorias')
                                           ->description('Categorias do evento.')
                                           ->collapsible()
                                           ->schema([
                                                        Repeater::make('categorias')
                                                            ->label('Categorias do Evento')
                                                            ->relationship('categorias') // Assumindo que você tem um relacionamento 'categorias' no seu modelo Evento
                                                            ->schema([
                                                                         \Filament\Schemas\Components\Group::make()
                                                                             ->columns(4)
                                                                             ->schema([
                                                                                          TextInput::make('name')
                                                                                              ->label('Nome da Categoria')
                                                                                              ->required()
                                                                                              ->maxLength(145),

                                                                                          TextInput::make('price')
                                                                                              ->label('Preço')
                                                                                              ->required()
                                                                                              ->currencyMask('.', ',')
                                                                                              ->numeric()
                                                                                              ->prefix('R$')
                                                                                              ->default(0),

                                                                                          TextInput::make('anoInicial')
                                                                                              ->label('Ano Nasc. Inicial')
                                                                                              ->numeric()
                                                                                              ->minValue(1900)
                                                                                              ->maxValue(2099)
                                                                                              ->required()
                                                                                              ->default(1949),

                                                                                          TextInput::make('anoFinal')
                                                                                              ->label('Ano Nasc. Final')
                                                                                              ->numeric()
                                                                                              ->minValue(1900)
                                                                                              ->maxValue(2099)
                                                                                              ->required()
                                                                                              ->default(2013),
                                                                                      ]),

                                                                         Textarea::make('description')
                                                                             ->label('Descrição da Categoria')
                                                                             ->rows(2),

                                                                         Toggle::make('permitirDupla')
                                                                             ->label('Permitir Dupla?')
                                                                             ->inline()
                                                                             ->default(false),
                                                                         Toggle::make('ativo')
                                                                             ->label('Ativo?')
                                                                             ->default(true)
                                                                             ->inline(false),

                                                                     ])
                                                            ->defaultItems(1)
                                                            ->createItemButtonLabel('Adicionar Categoria')
                                                            ->columns(1)
                                                            ->columnSpanFull()
                                                    ])
                                   ])->columns(1);
    }
}
