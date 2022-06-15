<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToComprasprodutotemporarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprasprodutotemporario', function (Blueprint $table) {
            $table->foreign(['nomeprodutoid'], 'comprasprodutotemporario_ibfk_1')->references(['id'])->on('nomeproduto')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['compraid'], 'comprasprodutotemporario_ibfk_2')->references(['id'])->on('compras')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprasprodutotemporario', function (Blueprint $table) {
            $table->dropForeign('comprasprodutotemporario_ibfk_1');
            $table->dropForeign('comprasprodutotemporario_ibfk_2');
        });
    }
}
