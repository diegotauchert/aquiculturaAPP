<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsAnexosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_anexos', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->BigInteger('post_id');
            $table->string('descricao')->nullable();
            $table->string('foto')->nullable();
            $table->string('arquivo')->nullable();
            $table->integer('tipo')->nullable();
            $table->integer('ordem')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('post_id')
                    ->references('id')->on('posts')
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
        Schema::dropIfExists('posts_anexos');
    }

}
