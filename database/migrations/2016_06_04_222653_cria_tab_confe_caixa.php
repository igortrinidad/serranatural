<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabConfeCaixa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferencias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('caixa_id');
            $table->integer('user_id');
            $table->integer('user_conf_id');
            $table->decimal('vr_abertura', 9, 2);
            $table->decimal('vendas', 9, 2);
            $table->decimal('vendas_cielo', 9, 2);
            $table->decimal('vendas_rede', 9, 2);
            $table->decimal('total_retirada', 9, 2);
            $table->decimal('diferenca_final', 9, 2);
            $table->decimal('vr_emCaixa', 9, 2);
            $table->datetime('dt_abertura', 9, 2);
            $table->integer('turno');
            $table->text('obs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('conferencias');
    }
}
