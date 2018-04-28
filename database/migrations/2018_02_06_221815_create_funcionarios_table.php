<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer ('user_id')->unsigned ();
            $table->integer ('departamento_id')->unsigned ();
            $table->timestamps();

            $table->foreign ('user_id')->references ('id')
                ->on ('users')->onDelete ('cascade');
            $table->foreign ('departamento_id')->references ('id')
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
        Schema::dropIfExists('funcionarios');
    }
}
