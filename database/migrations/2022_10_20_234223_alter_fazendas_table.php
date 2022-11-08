<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFazendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fazendas', function (Blueprint $table) {
            $table->integer('paymentgateway_plan_id')->nullable()->after("plano_id");
            $table->integer('paymentgateway_cartao_id')->nullable()->after("paymentgateway_plan_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fazendas', function (Blueprint $table) {
            $table->dropColumn('paymentgateway_plan_id');
            $table->dropColumn('paymentgateway_cartao_id');
        });
    }
}