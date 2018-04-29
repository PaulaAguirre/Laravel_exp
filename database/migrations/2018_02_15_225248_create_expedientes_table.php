<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpedientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer ('user_id')->unsigned ();
            $table->integer ('tipo_id')->unsigned ();
            $table->dateTime ('fecha_creacion');
            $table->integer ('cliente_id');
            $table->integer ('proveedor_id');
            $table->integer ('ot_id');
            $table->string ('referencia')->nullable ();
            $table->integer ('monto');
            $table->string ('notas');

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
        Schema::dropIfExists('expedientes');
    }
}
