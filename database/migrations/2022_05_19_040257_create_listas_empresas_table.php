<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListasEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listas_empresas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuarioid')->nullable()->index('usuarioid');
            $table->unsignedBigInteger('empresaid')->nullable()->index('empresaid');
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
        Schema::dropIfExists('listas_empresas');
    }
}
