<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValorvendaToComprasprodutotemporarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprasprodutotemporario', function (Blueprint $table) {
            //
            $table->decimal('valorvenda', 10)->nullable();
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
            //
            $table->dropColumn('valorvenda');
        });
    }
}
