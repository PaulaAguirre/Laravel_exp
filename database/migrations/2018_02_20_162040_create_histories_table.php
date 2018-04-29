<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer ('expediente_id')->unsigned ();
            $table->integer ('area_id')->unsigned ();
            $table->string ('estado')->nullable ()->default ('pendiente');
            $table->dateTime ('fecha_entrada');
            $table->string ('observaciones')->nullable ();
            $table->string ('observaciones_regularizacion')->nullable ();
            $table->integer ('aprobado_por');
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
        Schema::dropIfExists('histories');
    }
}
