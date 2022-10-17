<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('cliente_id')->nullable();
            $table->bigInteger('fazenda_id')->nullable();
            $table->bigInteger('viveiro_id')->nullable();
            $table->bigInteger('usuario_id')->nullable();
            $table->string('nome')->nullable();
            $table->string('cpf')->nullable();
            $table->string('telefone')->nullable();
            $table->string('vl_total')->nullable();
            $table->string('tipo')->nullable();
            $table->datetime('data')->nullable();
            $table->string('qtd_peixe')->nullable();
            $table->string('vl_peixe')->nullable();
            $table->string('gramatura_peixe')->nullable();
            $table->string('qtd_camarao')->nullable();
            $table->string('vl_camarao')->nullable();
            $table->string('gramatura_camarao')->nullable();
            $table->string('detalhes')->nullable();
            $table->integer('situacao');
            $table->string('arquivo')->nullable();

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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas');
    }

}
