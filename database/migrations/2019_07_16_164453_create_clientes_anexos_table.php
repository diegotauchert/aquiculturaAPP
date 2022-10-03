<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesAnexosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_anexos', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->BigInteger('cliente_id');
            $table->string('descricao')->nullable();
            $table->string('foto')->nullable();
            $table->string('arquivo')->nullable();
            $table->integer('tipo')->nullable();
            $table->integer('ordem')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('cliente_id')
                    ->references('id')->on('clientes')
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
        Schema::dropIfExists('clientes_anexos');
    }

}
