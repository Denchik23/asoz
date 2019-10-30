<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepmodelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repmodels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('repfirm_id');
            $table->string('name')->nullable();
            $table->integer('cartridgeprices');
            $table->integer('refueling');
            $table->integer('drum');
            $table->integer('raquel');
            $table->integer('rollercharge');
            $table->integer('magroller');
            $table->integer('blade');
            $table->integer('chip');
            $table->integer('resourceprint');
            $table->integer('toner');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('repmodels');
    }
}
