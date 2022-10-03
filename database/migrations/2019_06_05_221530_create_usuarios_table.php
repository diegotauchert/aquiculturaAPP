<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->string('nome');
            $table->string('login')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('foto')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('tipo');
            $table->integer('situacao');
            $table->string('token_access')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
