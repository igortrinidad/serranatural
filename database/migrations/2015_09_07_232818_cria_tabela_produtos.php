<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function ($table) {
            $table->increments('id');
            $table->string('nome_produto');
            $table->string('descricao');
            $table->string('fornecedorID');
            $table->integer('quantidadeEstoque');
            $table->boolean('is_venda');
            $table->boolean('is_materiaPrima');
            $table->boolean('is_ativo');
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
        Schema::drop('produtos');
    }
}
