<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsableForgotPasswordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsable_forgot_password', function (Blueprint $table) 
        {
            //$table->increments('id');
            $table->string('token', 16)->index()->unique();
            $table->string('email', 60)->references('email')->on('users');
            $table->dateTime('expiration_date');
            $table->boolean('used')->default(false);
            $table->string('dispositivo_token', 200)->references('token')->on('dispositivos_registrados');
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
        Schema::dropIfExists('responsable_forgot_password');
    }
}
