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
            $table->date('init')->after('motivo');
            $table->date('end')->after('init');
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
            $table->dropColumn('init');
            $table->dropColumn('end');
        });
    }
}
