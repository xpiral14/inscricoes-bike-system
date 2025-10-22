<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tb_evento_inscricoes');
        // ---------------------------------------------------------------------
        // PASSO 1: Criar a nova tabela principal com uma coluna de mapeamento temporária
        // ---------------------------------------------------------------------
        Schema::create('tb_evento_inscricoes', function (Blueprint $table) {
            $table->id();
            // Adicionamos uma coluna temporária para guardar o ID da tabela antiga
            $table->unsignedInteger('original_inscrito_id')->unique()->nullable();

            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('evento_id');
            $table->tinyInteger('situacao')->unsigned()->default(9);
            $table->double('paymentNetAmount')->default(0);
            $table->tinyInteger('paymentType')->unsigned()->default(0);
            $table->integer('paymentSubtype')->unsigned()->default(0);
            $table->tinyInteger('paymentInstallments')->unsigned()->default(0);
            $table->double('comissaobruta')->default(0);
            $table->unsignedInteger('divulgadorID')->default(0);
            $table->unsignedInteger('cupomDesc')->default(0);
            $table->double('pctDesconto')->default(0);
            $table->datetime('datacad')->default('1900-01-01 00:00:00');
            $table->datetime('dataconfirm')->default('1900-01-01 00:00:00');
            $table->datetime('datalimite')->default('1900-01-01 00:00:00');
            $table->datetime('releaseDate')->default('1900-01-01 00:00:00');
            $table->timestamps();
        });

        // ---------------------------------------------------------------------
        // PASSO 2: Migrar os dados em uma única query com INSERT ... SELECT
        // AVISO: FAÇA UM BACKUP DO SEU BANCO DE DADOS ANTES DE EXECUTAR!
        // ---------------------------------------------------------------------
        DB::insert(
            '
            INSERT INTO tb_evento_inscricoes (
                original_inscrito_id, usuario_id, evento_id, situacao, paymentNetAmount,
                paymentType, paymentSubtype, paymentInstallments, comissaobruta, divulgadorID,
                cupomDesc, pctDesconto, datacad, dataconfirm, datalimite, releaseDate,
                created_at, updated_at
            )
            SELECT
                id, usuario_id, evento, situacao, paymentNetAmount,
                paymentType, paymentSubtype, paymentInstallments, comissaobruta, divulgadorID,
                cupomDesc, pctDesconto, datacad, dataconfirm, datalimite, releaseDate,
                NOW(), NOW()
            FROM
                tb_eventos_inscritos
        '
        );

        // ---------------------------------------------------------------------
        // PASSO 3: Ligar a tabela antiga com a nova usando a coluna temporária
        // ---------------------------------------------------------------------
        Schema::table('tb_eventos_inscritos', function (Blueprint $table) {
            //$table->unsignedBigInteger('inscricao_id')->after('id')->nullable();
        });

        DB::update(
            '
            UPDATE tb_eventos_inscritos t_filho
            JOIN tb_evento_inscricoes t_pai ON t_filho.id = t_pai.original_inscrito_id
            SET t_filho.inscricao_id = t_pai.id
        '
        );

        // ---------------------------------------------------------------------
        // PASSO 4: Limpeza e finalização
        // ---------------------------------------------------------------------

        // Remover a coluna temporária da tabela principal
        Schema::table('tb_evento_inscricoes', function (Blueprint $table) {
            $table->dropColumn('original_inscrito_id');
        });

        Schema::table('tb_eventos', function (Blueprint $table) {
            $table->integer('limiteinscritos')->default(0);
        });
        Schema::table('tb_eventos_inscritos', function (Blueprint $table) {
            // Tornar a chave estrangeira não-nula e adicionar a constraint
            $table->unsignedBigInteger('inscricao_id')->nullable(false)->change();
            $table->foreign('inscricao_id')
                ->references('id')
                ->on('tb_evento_inscricoes')
                ->onDelete('cascade');

            //// Remover o índice e as colunas antigas
            //$table->dropUnique('usuario-evento-chave2');
            //$table->dropColumn([
            //                       'usuario_id', 'evento', 'datacad', 'datalimite', 'situacao',
            //                       'dataconfirm', 'paymentType', 'paymentSubtype', 'paymentInstallments',
            //                       'paymentNetAmount', 'comissaobruta', 'divulgadorID', 'cupomDesc',
            //                       'pctDesconto', 'releaseDate',
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
        // O método down permanece o mesmo, focado em reverter a estrutura.
        Schema::table('tb_eventos_inscritos', function (Blueprint $table) {
            //$table->unsignedInteger('usuario_id')->after('id');
            //$table->unsignedInteger('evento')->default(0)->after('usuario');
            //$table->datetime('datacad')->default('1900-01-01 00:00:00')->after('evento');
            //$table->datetime('datalimite')->default('1900-01-01 00:00:00')->after('datacad');
            //$table->tinyInteger('situacao')->unsigned()->default(9)->after('datalimite');
            //$table->datetime('dataconfirm')->default('1900-01-01 00:00:00')->after('situacao');
            //$table->tinyInteger('paymentType')->unsigned()->default(0)->after('price');
            //$table->integer('paymentSubtype')->unsigned()->default(0)->after('paymentType');
            //$table->tinyInteger('paymentInstallments')->unsigned()->default(0)->after('paymentSubtype');
            //$table->double('paymentNetAmount')->default(0)->after('paymentInstallments');
            //$table->double('comissaobruta')->default(0)->after('dtkitenviado');
            //$table->unsignedInteger('divulgadorID')->default(0)->after('comissaobruta');
            //$table->unsignedInteger('cupomDesc')->default(0)->after('chave2');
            //$table->double('pctDesconto')->default(0)->after('cupomDesc');
            //$table->datetime('releaseDate')->default('1900-01-01 00:00:00')->after('dtVlrDisponivel');

            $table->unique(['usuario', 'evento', 'chave2'], 'usuario-evento-chave2');

            if (Schema::hasColumn('tb_eventos_inscritos', 'inscricao_id')) {
                // Checagem para garantir que a chave estrangeira existe antes de tentar removê-la
                $sm          = Schema::getConnection()->getDoctrineSchemaManager();
                $foreignKeys = $sm->listTableForeignKeys('tb_eventos_inscritos');
                foreach ($foreignKeys as $foreignKey) {
                    if (in_array('inscricao_id', $foreignKey->getColumns())) {
                        $table->dropForeign($foreignKey->getName());
                    }
                }
                $table->dropColumn('inscricao_id');
            }
        });

        Schema::dropIfExists('tb_evento_inscricoes');
    }
};
