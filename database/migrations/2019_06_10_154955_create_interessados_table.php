<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInteressadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interessados', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('nome')->nullable();
            $table->string('email');
            $table->string('telefone')->nullable();
            $table->text('obs')->nullable();
            $table->integer('situacao');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interessados');
    }
}
