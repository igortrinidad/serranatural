<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaColunasCaixa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('caixas', function (Blueprint $table) {
            $table->integer('turno')->after('vr_emCaixa');
            $table->dropColumn('diferenca_cartoes');
            $table->dropColumn('diferenca_caixa');
            $table->dropColumn('fundo_caixa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('caixas', function (Blueprint $table) {
            $table->dropcolumn('turno');
            $table->decimal('diferenca_cartoes', 6, 2);
            $table->decimal('diferenca_caixa', 6, 2);
            $table->decimal('fundo_caixa', 6, 2);
        });
    }
}
