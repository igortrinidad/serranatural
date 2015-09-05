<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdicionaColunasAnalisePromocaoVotacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promocoes', function(Blueprint $table)
        {

            $table->integer('ticketsValidos');
            $table->integer('participantesUnicos');
            $table->integer('mediaTicketDia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            $table->integer('ticketsValidos');
            $table->integer('participantesUnicos');
            $table->integer('mediaTicketDia');
        }
}
