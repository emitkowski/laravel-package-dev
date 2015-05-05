<?php namespace App\Providers;

use App\Services\Support\Mailer;
use Illuminate\Support\ServiceProvider;


class MailerServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Register the binding
     *
     * @return void
     */
    public function register()
    {
//        $app = $this->app;
//
//        /**** Mailer Alert Email ***/
//        $app->bind('App\Services\Support\Mailer\Alert\AlertEmail', function()
//        {
//            return new Mailer\Alert\AlertEmail();
//        });
    }

}