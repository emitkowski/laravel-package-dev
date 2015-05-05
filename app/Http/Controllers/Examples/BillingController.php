<?php namespace App\Http\Controllers\Examples;

use Illuminate\Routing\Controller;
use App\Services\Support\Billing\BillingInterface as BillingInterface;

/**
 * Class BillingController
 *
 * Example of using Interface Dependency Injection in Controller
 *
 * @package App\Http\Controllers\Examples
 */
class BillingController extends Controller
{

    /**
     * Display Billing Type Injected
     *
     * @param BillingInterface $billing
     */
    public function getIndex(BillingInterface $billing)
    {
        //$billing = \App::make('StripeBilling');
        er('Billing set to: '.$billing->display());
    }

}
