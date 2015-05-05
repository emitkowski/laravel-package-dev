<?php namespace App\Services\Support\Billing;

class AuthorizeBilling implements BillingInterface
{

    /**
     * Display Billing name
     *
     * @return string
     */
    public function display()
    {
        return 'Authorize.net';
    }

}