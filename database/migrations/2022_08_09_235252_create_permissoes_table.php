<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissoes', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->BigInteger('usuario_id');
            $table->BigInteger('modulo_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('usuario_id')
                    ->references('id')->on('usuarios')
                    ->onDelete('cascade');
            $table->foreign('modulo_id')
                    ->references('id')->on('modulos')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissoes');
    }
}
