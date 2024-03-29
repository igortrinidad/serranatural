<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaColObservacoesCaixa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('caixas', function (Blueprint $table) {
            $table->text('obs')->after('is_aberto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('caixas', function (Blueprint $table) {
            $table->dropColumn('obs');
        });
    }
}
