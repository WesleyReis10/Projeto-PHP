<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToVendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('venda', function (Blueprint $table) {
            $table->foreign(['usuarioid'], 'venda_ibfk_1')->references(['id'])->on('usuarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('venda', function (Blueprint $table) {
            $table->dropForeign('venda_ibfk_1');
        });
    }
}
