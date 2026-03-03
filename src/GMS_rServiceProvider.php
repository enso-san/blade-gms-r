<?php

namespace EnsoSan\GMS_r;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;
use BladeUI\Icons\Factory;

final class GMS_rServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-gms-r.php', 'blade-gms-r');

        $this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
            $config = $container->make('config')->get('blade-gms-r', []);

            $factory->add('GMS_r', array_merge(['path' => __DIR__.'/../resources/svg'], $config));
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-gms-r'),
            ], 'blade-gms-r');

            $this->publishes([
                __DIR__.'/../config/blade-gms-r.php' => $this->app->configPath('blade-gms-r.php'),
            ], 'blade-gms-r-config');
        }
    }
}
