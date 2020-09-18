<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastLoginToResponsableAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('responsable_access', function (Blueprint $table) 
        {
            $table->dateTime('last_login_time')->nullable();
            $table->string('last_login_device_token', 200)->references('token')->on('dispositivos_registrados')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('responsable_access');
    }
}
