<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasprodutotemporarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprasprodutotemporario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('compraid')->nullable()->index('compraid');
            $table->unsignedBigInteger('nomeprodutoid')->nullable()->index('nomeprodutoid');
            $table->foreign('nomeprodutoid')->references('id')->on('nomeproduto');
            $table->foreign('compraid')->references('id')->on('compras');
            $table->text('codigodebarra', 250)->nullable();
            $table->decimal('valor', 10)->nullable();
            $table->integer('quantidade')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comprasprodutotemporario');
    }
}
