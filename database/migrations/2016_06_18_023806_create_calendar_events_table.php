<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        
        Schema::create('calendar_events', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->text('description');
            $table->integer('max_volunteer')->unsigned();
            $table->integer('num_registered_volunteers')->unsigned()->default(0);

            $table->text('address_street');
            $table->text('address_city');
            $table->text('address_state');
            $table->integer('address_zip');

            $table->decimal('coord_lat', 10, 7);
            $table->decimal('coord_lng', 10, 7);

            $table->text('google_city');
            $table->text('google_county');

            $table->integer('organization_id')->unsigned()->index();
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('calendar_event_volunteer', function (Blueprint $table) {
            $table->integer('calendar_event_id')->unsigned()->index();
            $table->foreign('calendar_event_id')->references('id')->on('calendar_events')->onDelete('cascade');
            
            $table->integer('volunteer_id')->unsigned()->index();
            $table->foreign('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
            $table->timestamps();
            $table->binary('hours_added');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */


    public function down()
    {
        Schema::drop('calendar_event_volunteer');
        Schema::drop('calendar_events');
    }

}
