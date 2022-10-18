<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducaoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producao', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('cliente_id')->nullable();
            $table->bigInteger('fazenda_id')->nullable();
            $table->bigInteger('viveiro_id')->nullable();
            $table->bigInteger('usuario_id')->nullable();
            $table->bigInteger('produto_id')->nullable();
            $table->integer('categoria_id');
            $table->string('qtd')->nullable();
            $table->string('ph')->nullable();
            $table->string('salinidade')->nullable();
            $table->string('turbidez')->nullable();
            $table->string('alcalinidade')->nullable();
            $table->string('oxigenio')->nullable();
            $table->string('temperatura')->nullable();
            $table->datetime('despesca')->nullable();
            $table->string('tara')->nullable();
            $table->string('gramatura')->nullable();
            $table->integer('situacao');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cliente_id')
                    ->references('id')->on('clientes')
                    ->onDelete('cascade');

            $table->foreign('fazenda_id')
                ->references('id')->on('fazendas')
                ->onDelete('cascade');

            $table->foreign('viveiro_id')
                ->references('id')->on('viveiros')
                ->onDelete('cascade');

            $table->foreign('usuario_id')
                ->references('id')->on('usuarios')
                ->onDelete('cascade');

            $table->foreign('produto_id')
                ->references('id')->on('produtos')
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
        Schema::dropIfExists('producao');
    }

}
