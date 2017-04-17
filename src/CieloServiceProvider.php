<?php

namespace jlcd\CieloLaravel;

use jlcd\Cielo\Cielo;
use Illuminate\Support\ServiceProvider;

class CieloServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $config_path = app()->basePath() . '/config/cielo.php';
        $this->publishes([
            __DIR__.'/config/config.php' => $config_path,
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('cielo', function ($app) {
            return new Cielo(config('cielo.merchant_id'), config('cielo.merchant_key'), config('cielo.environment'));
        });
    }
}
