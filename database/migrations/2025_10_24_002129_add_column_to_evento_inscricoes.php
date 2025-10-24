<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_evento_inscricoes', function (Blueprint $table) {
            $table->text('paymentLink')->nullable()->after('paymentInstallments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_evento_inscricoes', function (Blueprint $table) {
            $table->dropColumn('paymentLink');
        });
    }
};
