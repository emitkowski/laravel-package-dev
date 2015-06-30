<?php

namespace App\Providers;

use App\Services\Support\Logger;
use Illuminate\Support\ServiceProvider;

class LoggerServiceProvider extends ServiceProvider
{
    /**
     * Register the binding
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        /**** Logger Binding ***/
        $app->bind('logger', function () {
            return new Logger\MyLogger();
        });
    }

}