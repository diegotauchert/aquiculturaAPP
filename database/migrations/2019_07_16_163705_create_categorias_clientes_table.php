<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasClientesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias_clientes', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->BigInteger('categoria_id')->nullable();
            $table->string('nome');
            $table->integer('ordem')->nullable();
            $table->integer('situacao');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('categoria_id')
                    ->references('id')->on('categorias_clientes')
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
        Schema::dropIfExists('categorias_clientes');
    }

}
