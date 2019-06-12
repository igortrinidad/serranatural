<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaReceitas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receitas_pratos', function ($table) {
            $table->increments('id');
            $table->string('prato_id');
            $table->boolean('produto_id');
            $table->decimal('quantidade', 5, 2);
            $table->string('medida');
            $table->text('modo_preparo');
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
        Schema::drop('receitas_pratos');
    }
}
