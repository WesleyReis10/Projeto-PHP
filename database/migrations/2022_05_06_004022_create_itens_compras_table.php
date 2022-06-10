<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItensComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compraid')->nullable()->index('compraid');
            $table->unsignedBigInteger('produtoid')->nullable()->index('produtoid');
            $table->decimal('valor', 10)->nullable();
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
        Schema::dropIfExists('itens_compras');
    }
}
