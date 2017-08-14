<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RmSquareIdProduto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('square_id');
            $table->dropColumn('square_name');
            $table->dropColumn('calc');
        });

        Schema::table('caixas', function (Blueprint $table) {
            $table->datetime('estoquebaixadoem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->string('square_id');
            $table->string('square_name');
            $table->decimal('calc', 10,2);
        });
        Schema::table('caixas', function (Blueprint $table) {
            $table->dropColumn('estoquebaixadoem');
        });
    }
}
