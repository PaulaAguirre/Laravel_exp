<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaTipoexpedientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ('area_tipoxpedientes', function (Blueprint $table) {
            $table->increments ( 'id' );
            $table->integer ( 'tipoexpediente_id' )->unsigned ();
            $table->integer ( 'area_id' )->unsigned ();
            $table->timestamps ();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_tipoexpedientes');
    }
}
