<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvisosVistoResponsableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avisos_visto_responsables', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('aviso_id')->unsigned();
            $table->foreign('aviso_id')->references('id')->on('avisos__avisos')->onDelete('cascade');

            $table->integer('responsable_id')->unsigned();
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
        Schema::dropIfExists('avisos_visto_responsables');
    }
}
