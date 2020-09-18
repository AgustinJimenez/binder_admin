<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsableSuscripcionSeccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsable_suscripcion_seccion', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('responsable_id')->unsigned();
            $table->foreign('responsable_id')->references('id')->on('responsables__responsables')->onDelete('cascade');

            $table->integer('seccion_id')->unsigned();
            $table->foreign('seccion_id')->references('id')->on('grados__seccions');

            $table->string('dispositivo_token')->references('token')->on('dispositivos_registrados');

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
        Schema::dropIfExists('responsable_suscripcion_seccion');
    }
}
