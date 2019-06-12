<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaModelRecibosFunc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos_funcionarios', function (Blueprint $table) {
            $table->increments('id');
            $table->json('retiradas');
            $table->decimal('total_debito', 7, 2);
            $table->decimal('total_credito', 7, 2);
            $table->integer('funcionario_id');
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
        Schema::drop('recibos_funcionarios');
    }
}
