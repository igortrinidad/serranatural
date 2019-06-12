<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabPromocoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('promocoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->date('inicio');
            $table->date('fim');
            $table->text('descricao');
            $table->string('foto');
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
        Schema::drop('promocoes');
    }
}
