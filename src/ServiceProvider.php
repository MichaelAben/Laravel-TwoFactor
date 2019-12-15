<?php


namespace MabenDev\TwoFactor;


use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as provider;

class ServiceProvider extends provider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/Config/MabenDevTwoFactorConfig.php', 'MabenDevTwoFactor');
    }

    public function boot()
    {
        $this->loadMigrationsFrom( __DIR__.'/Migrations/');

        $this->loadViewsFrom(__DIR__.'/Views', 'MabenDevTwoFactor');

        $this->loadTranslationsFrom(__DIR__.'/Lang', 'MabenDevTwoFactor');

        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');

        /** @var Router $router */
        $router = $this->app['router'];
        $router->aliasMiddleware('TwoFactor', Middleware\TwoFactor::class);

        $this->publishes([
            __DIR__.'/Config/MabenDevTwoFactorConfig.php' => config_path('MabenDevTwoFactor.php'),

            __DIR__.'/Views' => resource_path('views/vendor/MabenDevTwoFactor'),

            __DIR__.'/lang' => resource_path('lang/vendor/MabenDevTwoFactor'),
        ], 'MabenDevTwoFactor');
    }
}
