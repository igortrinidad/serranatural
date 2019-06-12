<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaColsMovimentacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movimentacoes_produtos', function (Blueprint $table) {
            $table->dropColumn('motivo');
            $table->string('obs')->after('quantity');
            $table->string('type')->after('quantity');
            $table->integer('pagamento_id')->after('produto_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimentacoes_produtos', function (Blueprint $table) {
            $table->dropColumn('obs');
            $table->dropColumn('type');
            $table->dropColumn('pagamento_id');
        });
    }
}
