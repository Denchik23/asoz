<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_repair');
            $table->timestamp('date_begin')->nullable();
            $table->timestamp('date_end')->default('0000-00-00 00:00:00');
            $table->string('customer')->nullable();
            $table->string('phone')->nullable();
            $table->string('equipment');
            $table->string('repfirm');
            $table->string('repmodel');
            $table->string('serial')->nullable();
            $table->text('package');
            $table->text('malfunction');
            $table->integer('prices');
            $table->string('staff',100);
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
        Schema::drop('archives');
    }
}
