<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrcriaTabelaVotacaoPratoDoDia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votacaoPratosDoDia', function ($table) {
            $table->increments('id');
            $table->integer('clienteId');
            $table->string('pratos_id');
            $table->string('semanaCorrente');
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
        Schema::drop('votacaoPratosDoDia');
    }
}
