<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaColunasPrecosPratos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pratosDoDia', function(Blueprint $table)
        {
            $table->decimal('valor_pequeno', 7, 2);
            $table->decimal('valor_grande', 7, 2);
            $table->string('foto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pratosDoDia', function(Blueprint $table)
        {
            $table->dropColumn('valor_pequeno');
            $table->dropColumn('valor_grande');
            $table->dropColumn('foto');
        });
    }
}
