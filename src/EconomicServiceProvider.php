<?php

namespace LasseRafn\Economic;

use Illuminate\Support\ServiceProvider;

class EconomicServiceProvider extends ServiceProvider
{
    /**
     * Boot.
     */
    public function boot()
    {
        $configPath = __DIR__.'/config/economic.php';
        $this->mergeConfigFrom($configPath, 'economic');

        $configPath = __DIR__.'/config/economic.php';

        if (function_exists('config_path')) {
            $publishPath = config_path('economic.php');
        } else {
            $publishPath = base_path('config/economic.php');
        }

        $this->publishes([$configPath => $publishPath], 'config');
    }

    public function register()
    {
    }
}
