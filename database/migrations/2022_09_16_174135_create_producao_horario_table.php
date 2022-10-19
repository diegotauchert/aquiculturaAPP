<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducaoHorarioTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producao_horario', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('cliente_id')->nullable();
            $table->bigInteger('fazenda_id')->nullable();
            $table->bigInteger('viveiro_id')->nullable();
            $table->bigInteger('usuario_id')->nullable();
            $table->bigInteger('producao_id')->nullable();
            $table->string('hora')->nullable();
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

            $table->foreign('producao_id')
                ->references('id')->on('producao')
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
        Schema::dropIfExists('producao_horario');
    }

}
