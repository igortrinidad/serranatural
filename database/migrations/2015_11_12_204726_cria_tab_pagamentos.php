<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabPagamentos extends Migration
{

    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id_cadastro');
            $table->string('linha_digitavel');
            $table->string('descricao');
            $table->date('vencimento');
            $table->decimal('valor', 7, 2);
            $table->string('pagamento');
            $table->string('notaFiscal');
            $table->boolean('is_liquidado');
            $table->date('data_pgto');
            $table->integer('user_id_pagamento');
            $table->string('fonte_pgto');
            $table->string('comprovante');
            $table->text('observacoes');
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
        Schema::drop('pagamentos');
    }
}
