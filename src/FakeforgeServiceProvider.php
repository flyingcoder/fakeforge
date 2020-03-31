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
        if ($this->app->runningInConsole()) {
            $this->commands([
                FakeforgeCommand::class
            ]);
        }

        $this->loadRoutesFrom(__DIR__.'/routes.php');

        $this->publishes([
                __DIR__.'/config/fakeforge.php' => config_path('fakeforge.php'),
            ]);

        $this->publishes([
                __DIR__.'/sh' => base_path('/sh'),
            ]);
    }
}
