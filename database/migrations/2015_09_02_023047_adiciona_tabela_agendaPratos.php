<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdicionaTabelaAgendaPratos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendaPratos', function ($table) {
            $table->increments('id');
            $table->integer('pratos_id');
            $table->string('dataStr');
            $table->date('dataStamp');
            $table->boolean('ativo');
            $table->timestamps();
        });
    }

    /**array('pratoID', 'dataProg', 'ativo');
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('agendaPratos');
    }
}
