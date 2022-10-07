<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_logs', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->BigInteger('usuario_id')->nullable();
            $table->timestamp('data');
            $table->text('session');
            $table->string('ip');
            $table->text('mensagem')->nullable();
            $table->text('info');
            $table->integer('tipo');
            $table->integer('situacao');
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
        Schema::dropIfExists('usuarios_logs');
    }
}
