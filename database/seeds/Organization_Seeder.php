<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class Organization_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Organization::class, 5000)->create()->each(function($u) {
        $u->calendar()->save(factory(App\CalendarEvent::class)->make());
    	});
    }
}
