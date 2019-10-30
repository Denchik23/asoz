<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date_begin')->nullable();
            $table->timestamp('date_end')->default('0000-00-00 00:00:00');
            $table->string('customer')->nullable();
            $table->string('phone')->nullable();
            $table->integer('equipment_id');
            $table->integer('repfirm_id');
            $table->string('repmodel');
            $table->string('serial')->nullable();
            $table->text('package');
            $table->text('malfunction');
            $table->integer('prices');
            $table->integer('status');
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
        Schema::drop('repairs');
    }
}
