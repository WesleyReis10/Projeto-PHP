<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->decimal('valorcompra', 10)->nullable();
            $table->decimal('valorvenda', 10)->nullable();
            $table->string('nome', 200)->nullable();
            $table->unsignedBigInteger('categoriaid')->nullable()->index('categoriaid');
            $table->unsignedBigInteger('marcaid')->nullable()->index('marcaid');
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
        Schema::dropIfExists('produtos');
    }
}
