<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserofficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('useroffices', function (Blueprint $table) {
            $table->id();
            $table->string('u_name', 50);
            $table->string('u_avatar')->nullable()->default(null);
            $table->string('u_email', 100);
            $table->foreignId('position_id');
            $table->foreignId('division_id');
            $table->foreignId('roles_id');
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
        Schema::dropIfExists('useroffices');
    }
}
