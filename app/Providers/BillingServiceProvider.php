<?php namespace App\Providers;

use App\Services\Support\Billing\AuthorizeBilling;
use App\Services\Support\Billing\BraintreeBilling;
use App\Services\Support\Billing\StripeBilling;
use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
{
    /**
     * Register the binding
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        /**** Authorize Billing ***/
        $app->bind('AuthorizeBilling', function()
        {
            return new AuthorizeBilling();
        });

        /**** Braintree Billing ***/
        $app->bind('BraintreeBilling', function()
        {
            return new BraintreeBilling();
        });

        /**** Stripe Billing ***/
        $app->bind('StripeBilling', function()
        {
            return new StripeBilling();
        });

        // Choose Default Billing
        $app->bind('App\Services\Support\Billing\BillingInterface', 'BraintreeBilling');

    }

}