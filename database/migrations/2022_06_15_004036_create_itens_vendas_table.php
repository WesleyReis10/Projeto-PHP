<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItensVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens_vendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produtoid')->nullable()->index('produtoid');
            $table->unsignedBigInteger('vendaid')->nullable()->index('vendaid');
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
        Schema::dropIfExists('itens_vendas');
    }
}
