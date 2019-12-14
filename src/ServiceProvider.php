<?php


namespace MabenDev\TwoFactor;


use Illuminate\Support\ServiceProvider as provider;
use MabenDev\TwoFactor\Middleware\TwoFactor;

class ServiceProvider extends provider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/Config/MabenDevTwoFactorConfig.php', 'MabenDevTwoFactor');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/MabenDevTwoFactorConfig.php' => config_path('MabenDevTwoFactor.php'),
        ], 'config');

        $this->loadMigrationsFrom( __DIR__.'/Migrations/');

        $this->app['router']->aliasMiddleware('TwoFactor', TwoFactor::class);
    }
}
