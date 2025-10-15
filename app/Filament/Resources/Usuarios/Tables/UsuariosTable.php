<?php

namespace App\Filament\Resources\Usuarios\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class UsuariosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                          // 1. id
                          TextColumn::make('id')
                              ->label('ID')
                              ->sortable(),

                          // 2. nome
                          TextColumn::make('nome')
                              ->searchable(),

                          // 3. email
                          TextColumn::make('email')
                              ->label('Email') // Alterado de 'Email address' para 'Email'
                              ->searchable(),

                          // 4. cidade
                          TextColumn::make('cidade')
                              ->searchable(),

                          // 5. uf
                          TextColumn::make('uf')
                              ->label('UF')
                              ->searchable(),

                          // 6. dataCad
                          TextColumn::make('datacad')
                              ->label('Data Cad.')
                              ->dateTime('d/m/Y H:i') // Formato ajustado para corresponder ao HTML
                              ->sortable(),

                          // 7. qtdEventos (Rotulado como 'Eventos' no HTML)
                          TextColumn::make('eventos_count')
                              ->label('Eventos')
                              ->numeric()
                              ->sortable(),

                          // As colunas 'Visualizar' e 'Resetar Senha' são representadas pelas
                          // Ações de Registro (recordActions) do Filament.

                          // Colunas originais que foram removidas/reordenadas:
                          /*
                          TextColumn::make('tipo')->numeric()->sortable(),
                          TextColumn::make('senha')->searchable(),
                          TextColumn::make('salt')->searchable(),
                          TextColumn::make('email_confirmado')->numeric()->sortable(),
                          TextColumn::make('email_checkstring')->searchable(),
                          TextColumn::make('session_date')->dateTime()->sortable(),
                          TextColumn::make('tentativas_erradas')->numeric()->sortable(),
                          TextColumn::make('imagem')->searchable(),
                          TextColumn::make('datasenha')->dateTime()->sortable(),
                          TextColumn::make('telefone')->searchable(),
                          TextColumn::make('estado')->searchable(),
                          TextColumn::make('data_nascimento')->dateTime()->sortable(),
                          TextColumn::make('hashh')->searchable(),
                          TextColumn::make('data_confirmacao')->dateTime()->sortable(),
                          TextColumn::make('cpf')->searchable(),
                          TextColumn::make('primeiroevento')->numeric()->sortable(),
                          TextColumn::make('email_recover')->searchable(),
                          TextColumn::make('screenwidth')->numeric()->sortable(),
                          TextColumn::make('ipregistro')->searchable(),
                          TextColumn::make('instagram')->searchable(),
                          TextColumn::make('sexo')->searchable(),
                          TextColumn::make('numerocbc')->searchable(),
                          TextColumn::make('nomeequipe')->searchable(),
                          TextColumn::make('nomepai')->searchable(),
                          TextColumn::make('nomemae')->searchable(),
                          TextColumn::make('endereco')->searchable(),
                          TextColumn::make('rg')->searchable(),
                          TextColumn::make('bairro')->searchable(),
                          TextColumn::make('cep')->searchable(),
                          TextColumn::make('sangue')->searchable(),
                          TextColumn::make('categoria')->searchable(),
                          TextColumn::make('naturalidade')->searchable(),
                          TextColumn::make('altura')->searchable(),
                          TextColumn::make('tcalcado')->searchable(),
                          TextColumn::make('tagasalho')->searchable(),
                          TextColumn::make('tcamiseta')->searchable(),
                          TextColumn::make('tshort')->searchable(),
                          TextColumn::make('evtbike')->numeric()->sortable(),
                          TextColumn::make('evtcorrida')->numeric()->sortable(),
                          TextColumn::make('dtCadastroAtualizado')->dateTime()->sortable(),
                          TextColumn::make('apelido')->searchable(),
                          TextColumn::make('filiado2024')->numeric()->sortable(),
                          */
                      ])
            ->filters([
                          //
                      ])
            ->modifyQueryUsing(function ($query) {
                $query->withCount('eventos');
            })
            ->recordActions([
                                // Corresponde a 'Visualizar'
                                ViewAction::make(),

                                // Corresponde a 'Visualizar' / Edição
                                EditAction::make(),
                                Action::make('resetarSenha')
                                    ->label('Resetar Senha')
                                    ->icon('heroicon-o-key')
                                    ->color('warning')
                                    ->modalIcon('heroicon-o-key')
                                    ->requiresConfirmation()
                                    ->modalHeading('Resetar Senha do Usuário')
                                    ->modalDescription('Você tem certeza que deseja resetar a senha deste usuário? Uma nova senha temporária será gerada e exibida.')
                                    ->action(function ($record) {
                                        // 1. Gerar uma nova senha segura (8 caracteres alfanuméricos)
                                        $novaSenha = Str::random(8);
                                        // 2. Definir a lógica de 'salt' e 'senha' da sua função SQL na aplicação.
                                        // Sua função SQL fazia: SET @senha = MD5(concat(_password, @salt));
                                        // E salvava o 'salt'.

                                        // Se você estiver usando o sistema de autenticação padrão do Laravel (Bcrypt/Argon):
                                        $salt = Str::random(19); // Seu fn_zRandonString(19)
                                        $senha_md5_salt = md5($novaSenha . $salt);
                                        $record->update([
                                                            'senha' => $senha_md5_salt,
                                                            'salt' => $salt,
                                                            'tentativas_erradas' => 0,
                                                            'email_recover' => '',
                                                            'datasenha' => now(),
                                                        ]);

                                        // 3. Mostrar a nova senha em uma notificação de sucesso.
                                        Notification::make()
                                            ->title('Senha Resetada com Sucesso!')
                                            ->body("Email: $record->email<br /> Senha: <span style='font-weight: bold; background-color: #ffff00;'>{$novaSenha}</span>.")
                                            ->success()
                                            ->persistent()
                                            ->send();
                                    }),

                                // Para 'Resetar Senha', você teria que adicionar uma Ação Personalizada (Action)
                                // Se desejar, adicione a ação de resetar senha aqui. Por enquanto, mantive apenas as ações padrão.
                            ])
            ->toolbarActions([
                                 BulkActionGroup::make([
                                                           DeleteBulkAction::make(),
                                                       ]),
                             ]);
    }
}
