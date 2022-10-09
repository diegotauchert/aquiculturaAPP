<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViveirosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viveiros', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('cliente_id')->nullable();
            $table->bigInteger('fazenda_id')->nullable();
            $table->string('nome')->nullable();
            $table->string('largura')->nullable();
            $table->string('comprimento')->nullable();
            $table->string('profundidade')->nullable();
            $table->string('volume')->nullable();
            $table->string('area')->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('viveiros');
    }

}
