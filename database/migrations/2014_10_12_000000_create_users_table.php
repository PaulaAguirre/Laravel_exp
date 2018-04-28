<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string ('lastname');
            $table->string ('cedula');
            $table->string ('phone')->nullable ();
            $table->string ('mobile')->nullable ();
            $table->string('email')->unique();
            $table->string('password')->default (bcrypt ('secret'));
            $table->integer ('role_id')->unsigned ();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign ('role_id')->references ('id')->on ('roles')->onDelete ('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
