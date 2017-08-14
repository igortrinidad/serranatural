<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrTabelaSquareProduto extends Migration
{

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('squareproducts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('square_id');
            $table->string('square_name');
            $table->integer('produto_id');
            $table->decimal('quantidade_por_venda', 9, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('squareproducts');
    }

}
