<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaColPeriodRetiradas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retiradas', function (Blueprint $table) {
            $table->string('tipo')->after('descricao');
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
            $table->dropColumn('tipo');
        });
    }
}
