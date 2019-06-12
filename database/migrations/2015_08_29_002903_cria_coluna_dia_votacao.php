<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaColunaDiaVotacao extends Migration
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
            $table->string('diaVoto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('votacaoPratosDoDia', function(Blueprint $table)
        {
            $table->dropColumn('diaVoto');
        });
    }
}
