<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class Volunteer_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(App\Volunteer::class, 1000)->create();
    }
}
