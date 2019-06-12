<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaFuncionarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cpf');
            $table->string('identidade');
            $table->string('telefone');
            $table->string('endereco');
            $table->string('email');
            $table->string('horario_trabalho');
            $table->text('observacoes');
            $table->string('transporte');
            $table->decimal('vr_transporte', 7, 2);
            $table->decimal('vr_salario', 7, 2);
            $table->string('cargo');
            $table->date('dt_inicio');
            $table->string('foto');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('funcionarios');
    }
}
