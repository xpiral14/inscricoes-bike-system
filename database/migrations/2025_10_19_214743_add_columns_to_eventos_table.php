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
        Schema::table('tb_eventos', function (Blueprint $table) {
            $table->boolean('kit');
            $table->integer('limiteinscritos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_eventos', function (Blueprint $table) {
            $table->dropColumn('kit');
            $table->dropColumn('limiteinscritos');
        });
    }
};
