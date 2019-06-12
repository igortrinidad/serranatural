<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaColunaTipoUsuario extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type');
        });
    }

    public function down()
    {
    Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('user_type');
        });
    }

}
