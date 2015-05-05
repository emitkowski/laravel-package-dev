<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Register the binding
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;
    }

}