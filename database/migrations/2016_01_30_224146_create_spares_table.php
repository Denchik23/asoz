<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spares', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date_begin')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->integer('equipment_id');
            $table->integer('repfirm_id');
            $table->string('repmodel');
            $table->string('sparepart');
            $table->integer('prices');
            $table->integer('replacement');
            $table->integer('status');
            $table->text('discription');
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
        Schema::drop('spares');
    }
}
