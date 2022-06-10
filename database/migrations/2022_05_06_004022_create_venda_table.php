<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda', function (Blueprint $table) {
            $table->id();
            $table->string('documento', 200)->nullable();
            $table->unsignedBigInteger('empresaid')->nullable()->index('empresaid');
            $table->unsignedBigInteger('usuarioid')->nullable()->index('usuarioid');
            $table->unsignedBigInteger('clienteid')->nullable()->index('clienteid');
            $table->text('descricao')->nullable();
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
        Schema::dropIfExists('venda');
    }
}
