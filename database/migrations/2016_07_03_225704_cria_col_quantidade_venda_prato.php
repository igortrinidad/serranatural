<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaColQuantidadeVendaPrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agendaPratos', function (Blueprint $table) {
            $table->string('quantidade_venda')->after('dataStamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agendaPratos', function (Blueprint $table) {
            $table->dropColumn('quantidade_venda');
        });
    }
}
