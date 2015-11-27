<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaColunasFotoPrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pratosDoDia', function (Blueprint $table) {
            $table->string('titulo_foto');
        });
    }

    public function down()
    {
    Schema::table('upratosDoDia', function(Blueprint $table)
        {
            $table->dropColumn('foto');
        });
    }
}
