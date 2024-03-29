<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdicionaColunaAtivoPratosDoDia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pratosDoDia', function(Blueprint $table)
        {

            $table->boolean('ativo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('pratosDoDia', function(Blueprint $table)
        {
            $table->dropColumn('ativo');
        });
            
    }
}
