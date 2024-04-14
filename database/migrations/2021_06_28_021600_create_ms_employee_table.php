<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_employee', function (Blueprint $table) {
            $table->char('id_employee','36')->primary();
            $table->string('name_employee','100')->nullable();
            $table->mediumText('address_employee')->nullable();
            $table->char('city_employee','4')->nullable();
            $table->char('province_employee','2')->nullable();
            $table->string('phone_employee','50')->nullable();
            $table->char('email_employee','50')->nullable();
            $table->char('position_employee','36')->nullable();
            $table->char('division_employee','36')->nullable();
            $table->date('datejoin_employee')->nullable();
            $table->mediumText('photo_employee')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_employee');
    }
}