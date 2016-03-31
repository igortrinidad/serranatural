<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaColFontePgtoRetiradas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retiradas', function (Blueprint $table) {
            $table->string('fonte_pgto')->after('is_debito');
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
            $table->dropColumn('fonte_pgto');
        });
    }
}
