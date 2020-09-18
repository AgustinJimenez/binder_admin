<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBooleanSecionesColegio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('colegios__colegios', function (Blueprint $table) {
            $table->boolean('tiene_varias_secciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('colegios__colegios', function (Blueprint $table) {
            $table->dropColumn('tiene_varias_secciones');
        });
    }
}
