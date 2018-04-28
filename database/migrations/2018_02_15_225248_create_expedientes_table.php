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
            $table->string ('nombre');
            $table->timestamps();

            $table->foreign ('user_id')->references ('id')
                ->on ('users')->onDelete ('cascade');
            $table->foreign ('tipo_id')->references ('id')
                ->on ('tipoexpedientes')->onDelete ('cascade');
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
