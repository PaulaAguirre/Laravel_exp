<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string ('nombre');
            $table->string ('descripcion', '255')->nullable ();
            $table->string ('tipo', '1')->default ('D');
            $table->integer ('responsable_id')->unsigned ();
            $table->integer ('dependencia_id')->unsigned ()->nullable ();
            $table->timestamps();

            $table->foreign ('responsable_id')->references ('id')
                ->on ('users')->onDelete ('cascade');
            $table->foreign ('dependencia_id')->references ('id')
                ->on ('areas')->onDelete ('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
