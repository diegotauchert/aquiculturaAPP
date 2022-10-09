<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('nome')->nullable();
            $table->integer('qtd_viveiros')->nullable()->default(0);
            $table->integer('carencia')->nullable()->default(0);
            $table->string('valor')->nullable();
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
        Schema::dropIfExists('planos');
    }

}
