<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('categoria_id')->nullable();
            $table->string('nome');
            $table->string('video')->nullable();
            $table->string('link')->nullable();
            $table->datetime('data');
            $table->longText('texto')->nullable();
            $table->text('descricao')->nullable();
            $table->integer('destaque')->default(1)->nullable();
            $table->integer('situacao');
            $table->integer('views')->default(0);
            $table->text('seo_keyword')->nullable();
            $table->text('seo_description')->nullable();
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
        Schema::dropIfExists('posts');
    }

}
