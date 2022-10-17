<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCultivoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cultivo', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('cliente_id')->nullable();
            $table->bigInteger('fazenda_id')->nullable();
            $table->bigInteger('viveiro_id')->nullable();
            $table->bigInteger('usuario_id')->nullable();
            $table->integer('categoria_id');
            $table->string('nome')->nullable();
            $table->string('tipo')->nullable();
            $table->string('biometria')->nullable();
            $table->string('adensamento')->nullable();
            $table->datetime('povoado')->nullable();
            $table->datetime('despesca')->nullable();
            $table->string('peso')->nullable();
            $table->string('peso_2')->nullable();
            $table->string('detalhes')->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cultivo');
    }

}
