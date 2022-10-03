<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->BigInteger('modulo_id')->nullable();
            $table->string('nome');
            $table->text('link');
            $table->integer('menu');
            $table->integer('situacao');
            $table->integer('exibe');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('modulos');
    }
}
