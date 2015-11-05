<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaCaixas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caixas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id_abertura');
            $table->integer('user_id_fechamento');
            $table->decimal('vr_abertura', 7, 2);
            $table->decimal('vendas_cash', 7, 2);
            $table->decimal('vendas_card', 7, 2);
            $table->decimal('vendas_cielo', 7, 2);
            $table->decimal('vendas_rede', 7, 2);
            $table->decimal('total_retirada', 7, 2);
            $table->decimal('esperado_caixa', 7, 2);
            $table->decimal('vr_emCaixa', 7, 2);
            $table->decimal('diferenca_cartoes', 7, 2);
            $table->decimal('diferenca_caixa', 7, 2);
            $table->decimal('diferenca_final', 7, 2);
            $table->decimal('fundo_caixa', 7, 2);
            $table->datetime('dt_abertura');
            $table->datetime('dt_fechamento');
            $table->boolean('is_aberto');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('caixas');
    }
}
