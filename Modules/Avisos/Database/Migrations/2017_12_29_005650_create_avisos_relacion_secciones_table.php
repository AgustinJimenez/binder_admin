<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvisosRelacionSeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avisos__relacion__secciones', function (Blueprint $table) 
        {
            $table->increments('id');
            $table->integer('aviso_id')->unsigned();
            $table->foreign('aviso_id')->references('id')->on('avisos__avisos')->onDelete('cascade');
            $table->integer('seccion_id')->unsigned();
            $table->foreign('seccion_id')->references('id')->on('grados__seccions');
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
        Schema::dropIfExists('avisos__relacion__secciones');
    }
}
