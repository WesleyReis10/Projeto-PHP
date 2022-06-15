<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToNomeprodutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nomeproduto', function (Blueprint $table) {
            $table->foreign(['categoriaid'], 'nomeproduto_ibfk_1')->references(['id'])->on('categorias')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['marcaid'], 'nomeproduto_ibfk_2')->references(['id'])->on('marcas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nomeproduto', function (Blueprint $table) {
            $table->dropForeign('nomeproduto_ibfk_1');
            $table->dropForeign('nomeproduto_ibfk_2');
        });
    }
}
