<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAcessoModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acesso_modulos', function (Blueprint $table) {
            $table->foreign(['moduloid'], 'modulos_ibfk_1')->references(['id'])->on('modulos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acesso_modulos', function (Blueprint $table) {
            $table->dropForeign('modulos_ibfk_1');
        });
    }
}
