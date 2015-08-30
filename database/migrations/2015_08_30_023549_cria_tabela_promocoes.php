<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaPromocoes extends Migration

{

    public function up()
    {
        Schema::create('promocoes', function ($table) {
            $table->increments('id');
            $table->string('nome_promocao');
            $table->boolean('ativo')->default(0);
            $table->date('data_inicio');
            $table->date('data_termino');
            $table->integer('clientId');
            $table->string('nomeCliente');
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
        Schema::drop('promocoes');
    }
}
