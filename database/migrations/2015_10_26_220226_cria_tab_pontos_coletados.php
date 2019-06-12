<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabPontosColetados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pontos_coletados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned(); // FK clientes id
            $table->date('data_coleta');
            $table->date('vencimento');
            $table->integer('voucher_id')->unsigned();
            $table->boolean('is_valido');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pontos_coletados');
    }
}
