<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToItensVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itens_vendas', function (Blueprint $table) {
            $table->foreign(['produtoid'], 'itens_vendas_ibfk_1')->references(['id'])->on('produtos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['vendaid'], 'itens_vendas_ibfk_2')->references(['id'])->on('venda')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itens_vendas', function (Blueprint $table) {
            $table->dropForeign('itens_vendas_ibfk_1');
            $table->dropForeign('itens_vendas_ibfk_2');
        });
    }
}
