<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartridgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartridges', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date_begin')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->integer('repfirm_id');
            $table->integer('printmodels_id');
            $table->integer('number');
            $table->text('datacartridge');
            $table->integer('prices');
            $table->integer('staff_id');
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
        Schema::drop('cartridges');
    }
}
