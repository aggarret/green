<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_post_id')->unsigned();
            $table->integer('calendar_id');
            $table->string('users_post_type');
            $table->string('image');
            $table->string('shared');
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
        Schema::drop('photos');
    }
}
