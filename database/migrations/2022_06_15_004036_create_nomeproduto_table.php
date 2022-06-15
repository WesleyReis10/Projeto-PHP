<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomeprodutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomeproduto', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('categoriaid')->nullable();
            $table->unsignedBigInteger('marcaid')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nomeproduto');
    }
}
