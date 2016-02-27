<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabMovimetnacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimentacoes_produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produto_id');
            $table->integer('user_id');
            $table->string('type');
            $table->decimal('quantity', 6, 2);
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
        Schema::drop('movimentacoes_produtos');
    }
}
