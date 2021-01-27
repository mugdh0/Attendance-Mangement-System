<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_calculations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('time_in');
            $table->string('time_out');
            $table->string('date');
            $table->string('status');
            $table->integer('late')->default(0);
            $table->integer('present')->default(0);
            $table->integer('absent')->default(0);
            $table->integer('leave')->default(0);
            $table->integer('leave_token')->default(0);
            $table->integer('holiday_token')->default(0);
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
        Schema::dropIfExists('attendance_calculations');
    }
}
