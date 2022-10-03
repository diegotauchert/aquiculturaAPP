<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaginasAnexosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paginas_anexos', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->BigInteger('pagina_id');
            $table->string('descricao')->nullable();
            $table->string('arquivo')->nullable();
            $table->integer('tipo')->nullable();
            $table->string('foto')->nullable();
            $table->integer('ordem')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('pagina_id')
                    ->references('id')->on('paginas')
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
        Schema::dropIfExists('paginas_anexos');
    }

}
