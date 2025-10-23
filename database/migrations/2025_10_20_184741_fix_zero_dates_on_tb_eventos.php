<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixZeroDatesOnTbEventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Desabilita temporariamente o modo estrito para permitir a correção dos dados.
        // O DB::unprepared() é usado para garantir a execução de comandos que alteram o estado da sessão.
        DB::unprepared("
            SET SESSION sql_mode = REPLACE(@@sql_mode, 'NO_ZERO_DATE', '');
        ");

        // 2. Corrige os dados problemáticos na coluna 'datacad'.
        // O valor '0000-00-00 00:00:00' será alterado para NULL.
        // Assumimos que a coluna 'datacad' permite valores NULL.
        // Se ela for NOT NULL, use '1970-01-01 00:00:01' em vez de NULL.
        DB::statement("
            UPDATE `tb_eventos`
            SET `datacad` = NULL
            WHERE `datacad` = '0000-00-00 00:00:00'
        ");


        // 3. Opcional: Altera a definição da coluna para aceitar NULL, prevenindo futuros erros de '0000-00-00 00:00:00'.
        // Isso é altamente recomendado.
        DB::statement("
            ALTER TABLE `tb_eventos`
            MODIFY COLUMN `datacad` DATETIME NULL DEFAULT NULL
        ");

        DB::statement("
            ALTER TABLE `tb_eventos_inscritos`
            MODIFY COLUMN `dtkitenviado` DATETIME NULL DEFAULT NULL
        ");

        DB::statement("
            UPDATE `tb_eventos_inscritos`
            SET `dtkitenviado` = null
            WHERE `dtkitenviado` = '0000-00-00 00:00:00'
        ");

        // 5. Restaura o modo SQL original (opcional, mas recomendado para limpeza).
        // Em muitos ambientes, a sessão se encerra, mas é um bom princípio de código.
        DB::unprepared("
            SET SESSION sql_mode = CONCAT(@@sql_mode, ',NO_ZERO_DATE');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Ações de reversão (down):

        // Nota: A correção dos dados (de '0000-00-00 00:00:00' para NULL)
        // e a mudança do sql_mode não são revertidas, pois reverter a correção
        // traria o erro de volta e é má prática de migração.
    }
}
