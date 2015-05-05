<?php namespace Pigeon;

use Illuminate\Support\ServiceProvider;


/**
 * Class PigeonServiceProvider
 * @package Pigeon
 *
 */
class PigeonServiceProvider extends ServiceProvider
{

    public function register()
    {
        // Bind the library desired to the interface
        $this->app->bind('Pigeon\PigeonInterface', 'Pigeon\\'.config('pigeon.library'));

        // Bind the Pigeon Interface to the facade
        $this->app->bind('pigeon', 'Pigeon\PigeonInterface');
    }

    public function boot()
    {
        require __DIR__ . '/../../../../vendor/autoload.php';

        $this->publishes([
            __DIR__.'/config/pigeon.php' => config_path('pigeon.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/views/' => base_path('resources/views'),
        ], 'views');

    }

}