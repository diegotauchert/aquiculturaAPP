<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('categoria_id')->nullable();
            $table->string('nome')->nullable();
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->datetime('dt_nasc')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('orgao')->nullable();
            $table->string('uf')->nullable();
            $table->string('cep')->nullable();
            $table->string('endereco')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('complemento')->nullable();
            $table->string('estado')->nullable();
            $table->string('cidade')->nullable();
            $table->string('plano')->nullable();
            $table->integer('fazendas')->nullable();
            $table->string('valor')->nullable();
            $table->integer('status')->nullable();
            $table->datetime('validade')->nullable();
            $table->text('obs')->nullable();
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
        Schema::dropIfExists('clientes');
    }

}
