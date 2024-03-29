<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlteraPivotPratosProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('pratos_produtos', function ($table) {
            $table->integer('prato_id');
            $table->integer('produto_id');
            $table->decimal('quantidade', 6, 3);
            $table->string('unidade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pratos_produtos', function ($table) {
            $table->drop('pratos_produtos');
        });
    }
}
