<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('float', function ($attribute, $value, $parameters, $validator) {
            return is_float($value);
        });
        Validator::replacer('float', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'O atributo ":attribute" deve ser do tipo float.');
        });
    }
}
