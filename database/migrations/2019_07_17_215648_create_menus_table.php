<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('menu_id')->nullable();
            $table->string('nome');
            $table->string('link');
            $table->integer('situacao');
            $table->integer('exibe');
            $table->integer('ordem')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('menu_id')
                    ->references('id')->on('menus')
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
        Schema::dropIfExists('menus');
    }
}
