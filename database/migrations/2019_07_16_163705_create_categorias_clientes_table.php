<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasPostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias_posts', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->BigInteger('categoria_id')->nullable();
            $table->string('nome');
            $table->integer('ordem')->nullable();
            $table->integer('situacao');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('categoria_id')
                    ->references('id')->on('categorias_posts')
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
        Schema::dropIfExists('categorias_posts');
    }

}
