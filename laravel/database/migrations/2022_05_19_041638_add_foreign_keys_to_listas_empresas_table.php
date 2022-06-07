<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToListasEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listas_empresas', function (Blueprint $table) {
            //
            $table->foreign(['usuarioid'], 'listas_empresas_ibfk_1')->references(['id'])->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['empresaid'], 'listas_empresas_ibfk_2')->references(['id'])->on('empresas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listas_empresas', function (Blueprint $table) {
            //
            $table->dropForeign('listas_empresas_ibfk_1');
            $table->dropForeign('listas_empresas_ibfk_2');
        });
    }
}
