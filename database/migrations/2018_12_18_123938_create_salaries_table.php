<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emoloyee_id');
            $table->double('basic_salary', 8, 2);
            $table->double('house_rent_allowance', 8, 2);
            $table->double('bonus', 8, 2);
            $table->double('conveyance', 8, 2);
            $table->double('other_allowance', 8, 2);
            $table->double('TDS', 8, 2);
            $table->double('provident_fund', 8, 2);
            $table->double('c_bank_loan', 8, 2);
            $table->double('other_deductions', 8, 2);
            
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
        Schema::dropIfExists('salaries');
    }
}
