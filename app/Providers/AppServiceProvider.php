<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;

use Illuminate\Support\ServiceProvider;

use Validator;

use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Validator::extend('future_start', function($attribute, $value, $parameters, $validator) {
            if($value >=Carbon::now() ) {
                return true;
            }
                return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
