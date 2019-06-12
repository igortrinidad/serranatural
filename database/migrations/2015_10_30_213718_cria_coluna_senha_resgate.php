<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaColunaSenhaResgate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Cria coluna de senha de resgate na tabela cliente
        Schema::table('clientes', function(Blueprint $table)
        {
            $table->integer('senha_resgate')->after('telefone');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('clientes', function(Blueprint $table)
        {
            $table->dropColumn('senha_resgate');

        });
    }
}
