<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaColAutorizationsRetirada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retiradas', function (Blueprint $table) {
            $table->integer('autorizado_por')->after('fonte_pgto');
            $table->datetime('autorizado_quando')->after('fonte_pgto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('retiradas', function (Blueprint $table) {
            $table->dropColumn('autorizacao_por');
            $table->dropColumn('autorizacao_quando');
        });
    }
}
