<?php namespace App\Http\Controllers\Examples;

use App\Services\Support\Alert\Type\WebopsAlert as WebopsAlert;
use App\Services\Support\Logger\MyLogger as MyLogger;
use Illuminate\Routing\Controller;
use TestPackage\Test;

class TestController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function getIndex()
    {
        er('Test Controller');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @param Test $package
     * @return Response
     */
    public function getPackage(Test $package)
    {
        $package->announce();
    }


    /**
     *  Test Alert Service
     * @param WebopsAlert $alert_service
     * @internal param WebopsAlert $alert
     */
    public function getAlert(WebopsAlert $alert_service)
    {
        $alert_service->alert('Test Alert', 'This is a test alert!');
        er('Alert Sent');
    }

    /**
     *  Test Logger Service
     * @param MyLogger $logger
     */
    public function getLogger(MyLogger $logger)
    {
        $logger->write('Test Info Log', 'Test Controller', 0);
        $logger->write('Test Warning Log', 'Test Controller', 0, 'warning');
        $logger->write('Test Error Log', 'Test Controller', 0, 'error');
        er('Logs Written');
    }

}
