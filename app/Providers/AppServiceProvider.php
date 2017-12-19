<?php

namespace App\Providers;

use App\Http\Validators\EmailConfirmedValidator;
use Validator;
use Carbon\Carbon;
use App\Services\Settings;
use App\Http\Validators\HashValidator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCustomValidators();
        $this->setDefaultDateLocale();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //register dev service providers
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }


    /**
     * Register custom validation rules with laravel.
     */
    private function registerCustomValidators()
    {
        Validator::extend('hash', 'App\Http\Validators\HashValidator@validate');
        Validator::extend('email_confirmed', 'App\Http\Validators\EmailConfirmedValidator@validate');
    }


    /**
     * Set default date locale for the app.
     */
    private function setDefaultDateLocale()
    {
        $locale = $this->app->make(Settings::class)->get('dates.locale');
        Carbon::setLocale($locale);
    }
}
