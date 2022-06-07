<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToItensComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itens_compras', function (Blueprint $table) {
            $table->foreign(['compraid'], 'itens_compras_ibfk_1')->references(['id'])->on('compras')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['produtoid'], 'itens_compras_ibfk_2')->references(['id'])->on('produtos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itens_compras', function (Blueprint $table) {
            $table->dropForeign('itens_compras_ibfk_1');
            $table->dropForeign('itens_compras_ibfk_2');
        });
    }
}
