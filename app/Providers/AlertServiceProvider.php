<?php namespace App\Providers;

use App\Services\Support\Alert;
use Illuminate\Support\ServiceProvider;


class AlertServiceProvider extends ServiceProvider
{
    /**
     * Register the binding
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        /**** Webops Alert Binding ***/
        $app->bind('WebopsAlert', function()
        {
            $alert_mailer = \App::make('App\Services\Support\Mailer\Alert\AlertEmail');
            return new Alert\Type\WebopsAlert($alert_mailer);
        });
    }

}