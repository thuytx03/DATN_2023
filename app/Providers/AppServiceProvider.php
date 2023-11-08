<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
{
    Validator::extend('greater_than_field', function ($attribute, $value, $parameters, $validator) {
        $minField = $parameters[0];
        $min_limit = $validator->getData()[$minField];
        return $value > $min_limit;
    });

    Validator::extend('lt', function ($attribute, $value, $parameters, $validator) {
        return $value < $parameters[0];
    });
}
}
