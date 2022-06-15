<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->foreign(['categoriaid'], 'produtos_ibfk_1')->references(['id'])->on('categorias')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['marcaid'], 'produtos_ibfk_2')->references(['id'])->on('marcas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropForeign('produtos_ibfk_1');
            $table->dropForeign('produtos_ibfk_2');
        });
    }
}
