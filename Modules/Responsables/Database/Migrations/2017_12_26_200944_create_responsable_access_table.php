<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsableAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsable_access', function (Blueprint $table) 
        {
            //$table->increments('id');
            $table->string('token', 16)->index()->unique();
            $table->integer('responsable_id')->unsigned()->unique();
            $table->foreign('responsable_id')->references('id')->on('responsables__responsables')->onDelete('cascade');

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
        Schema::dropIfExists('responsable_access');
    }
}
