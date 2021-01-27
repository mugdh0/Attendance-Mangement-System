<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_counts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emp_id');
            $table->integer('leave_taken')->default(0);
            $table->integer('leave_remain')->default(0);
            $table->string('last_leave');
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
        Schema::dropIfExists('leave_counts');
    }
}
