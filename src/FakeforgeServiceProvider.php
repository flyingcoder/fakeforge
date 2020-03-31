<?php

namespace Flyingcoder\Fakeforge;

use Illuminate\Support\ServiceProvider;

class FakeforgeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                FakeforgeInitCommand::class
            ]);
        }

        $this->publishes([
                __DIR__.'/config/fakeforge.php' => config_path('fakeforge.php'),
            ]);

        $this->publishes([
                __DIR__.'/sh' => base_path('public/sh'),
            ]);
    }
}
