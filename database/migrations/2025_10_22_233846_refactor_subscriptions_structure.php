<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // --------------------------------------------------------------------
        // ETAPA 1: Preparar as tabelas com as novas colunas
        // --------------------------------------------------------------------

        // Adiciona as colunas que armazenarão os dados da transação/grupo na tabela "pai".
        Schema::table('tb_evento_inscricoes', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id')->after('evento_id');
            $table->tinyInteger('situacao')->unsigned()->default(9)->after('usuario_id');
            $table->dateTime('datacad')->default('1900-01-01 00:00:00')->after('situacao');
            $table->dateTime('dataconfirm')->default('1900-01-01 00:00:00')->after('datacad');
            $table->double('price')->default(0)->after('dataconfirm');
            $table->double('paymentNetAmount')->default(0)->after('price');
            $table->tinyInteger('paymentType')->unsigned()->default(0)->after('paymentNetAmount');

             $table->foreign('usuario_id')->references('id')->on('tb_usuarios');
        });

        // Adiciona a coluna que vai ligar o inscrito (filho) ao registro de inscrição (pai)
        Schema::table('tb_eventos_inscritos', function (Blueprint $table) {
            $table->unsignedBigInteger('inscricao_id')->nullable()->after('id');
        });


        // --------------------------------------------------------------------
        // ETAPA 2: Migrar os dados existentes
        // --------------------------------------------------------------------

        // Processa em lotes (chunks) para não sobrecarregar a memória
        DB::table('tb_eventos_inscritos')->orderBy('id')->chunk(200, function ($inscritos) {
            foreach ($inscritos as $inscrito) {
                // Cria o registro "pai" na tabela tb_evento_inscricoes
                $inscricaoId = DB::table('tb_evento_inscricoes')->insertGetId([
                                                                                  'evento_id' => $inscrito->evento,
                                                                                  'usuario_id' => $inscrito->usuario_id,
                                                                                  'situacao' => $inscrito->situacao,
                                                                                  'datacad' => $inscrito->datacad,
                                                                                  'dataconfirm' => $inscrito->dataconfirm,
                                                                                  'price' => $inscrito->price,
                                                                                  'paymentNetAmount' => $inscrito->paymentNetAmount,
                                                                                  'paymentType' => $inscrito->paymentType,
                                                                              ]);

                // Atualiza o registro "filho" para apontar para o novo registro "pai"
                DB::table('tb_eventos_inscritos')
                    ->where('id', $inscrito->id)
                    ->update(['inscricao_id' => $inscricaoId]);
            }
        });


        // --------------------------------------------------------------------
        // ETAPA 3: Limpeza e finalização das constraints
        // --------------------------------------------------------------------

        // Adiciona a constraint de chave estrangeira agora que os dados estão populados
        Schema::table('tb_eventos_inscritos', function (Blueprint $table) {
            // Torna a coluna não-nula e adiciona a FK
            //$table->unsignedBigInteger('inscricao_id')->nullable(false)->change();
            //$table->foreign('inscricao_id')->references('id')->on('tb_evento_inscricoes')->onDelete('cascade');
            //
            //// Remove o índice único antigo que será invalidado
            //$table->dropUnique('usuario-evento-chave2');
            //
            //// Remove as colunas que foram movidas para a tabela "pai"
            //$table->dropColumn([
            //                       'usuario_id',
            //                       'evento',
            //                       'datacad',
            //                       'datalimite',
            //                       'situacao',
            //                       'dataconfirm',
            //                       'price',
            //                       'paymentType',
            //                       'paymentSubtype',
            //                       'paymentInstallments',
            //                       'paymentNetAmount'
            //                   ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // ETAPA 1 (Reversa): Readicionar colunas na tabela filha e remover FK
        Schema::table('tb_eventos_inscritos', function (Blueprint $table) {
            $table->dropForeign(['inscricao_id']);

            // Adiciona as colunas de volta
            $table->integer('usuario_id')->unsigned()->default(0)->after('id');
            $table->integer('evento')->unsigned()->default(0)->after('usuario_id');
            $table->dateTime('datacad')->default('1900-01-01 00:00:00')->after('evento');
            $table->dateTime('datalimite')->default('1900-01-01 00:00:00')->after('datacad');
            $table->tinyInteger('situacao')->unsigned()->default(9)->after('datalimite');
            $table->dateTime('dataconfirm')->default('1900-01-01 00:00:00')->after('situacao');
            $table->double('price')->default(0)->after('dataconfirm');
            $table->tinyInteger('paymentType')->unsigned()->default(0)->after('price');
            $table->integer('paymentSubtype')->unsigned()->default(0)->after('paymentType');
            $table->tinyInteger('paymentInstallments')->unsigned()->default(0)->after('paymentSubtype');
            $table->double('paymentNetAmount')->default(0)->after('paymentInstallments');
        });

        // ETAPA 2 (Reversa): Migrar dados de volta
        // AVISO: Isso assume uma relação 1:1 na reversão.
        $inscricoes = DB::table('tb_evento_inscricoes')->get();
        foreach ($inscricoes as $inscricao) {
            DB::table('tb_eventos_inscritos')
                ->where('inscricao_id', $inscricao->id)
                ->update([
                             'usuario_id' => $inscricao->usuario_id,
                             'evento' => $inscricao->evento_id,
                             'situacao' => $inscricao->situacao,
                             'datacad' => $inscricao->datacad,
                             'dataconfirm' => $inscricao->dataconfirm,
                             'price' => $inscricao->price,
                             'paymentNetAmount' => $inscricao->paymentNetAmount,
                             'paymentType' => $inscricao->paymentType,
                         ]);
        }

        // ETAPA 3 (Reversa): Limpar a estrutura nova
        Schema::table('tb_eventos_inscritos', function (Blueprint $table) {
            $table->dropColumn('inscricao_id');
            $table->unique(['usuario', 'evento', 'chave2'], 'usuario-evento-chave2');
        });

        Schema::table('tb_evento_inscricoes', function (Blueprint $table) {
            // Se você adicionou a FK de usuário, remova-a aqui
            // $table->dropForeign(['usuario_id']);

            $table->dropColumn([
                                   'usuario_id',
                                   'situacao',
                                   'datacad',
                                   'dataconfirm',
                                   'price',
                                   'paymentNetAmount',
                                   'paymentType'
                               ]);
        });
    }
};
