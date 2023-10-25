<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Traits\Captcha;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    use Captcha;

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
        Validator::extend('captcha', function ($attribute, $value, $parameters) {
            return $this->captchaValidation($value);
        });
    }
}
