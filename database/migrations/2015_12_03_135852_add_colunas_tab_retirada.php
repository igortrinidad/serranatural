<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColunasTabRetirada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retiradas', function (Blueprint $table) {
            $table->integer('funcionario_id')->after('caixa_id');
            $table->integer('retirado_caixa')->after('user_id');
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
            $table->dropColumn('funcionario_id');
            $table->dropColumn('retirado_caixa');
        });
    }
}
