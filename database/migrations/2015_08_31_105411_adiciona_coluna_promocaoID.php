<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdicionaColunaPromocaoID extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('votacaoPratosDoDia', function(Blueprint $table)
        {

            $table->integer('promocaoID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('agendaPratos', function ($table) {
            $table->dropColumn('promocaoID');
        });
            
    }
    
}
