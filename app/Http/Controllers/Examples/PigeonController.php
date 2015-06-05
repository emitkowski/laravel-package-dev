<?php namespace App\Http\Controllers\Examples;

use Illuminate\Routing\Controller;
use Larablocks\Pigeon\Pigeon;
use Larablocks\Pigeon\PigeonInterface;

class PigeonController extends Controller
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getIndex(PigeonInterface $mailer)
    {
        er('Start Mailer');

        $message_data['first_name'] = 'John';
        $message_data['last_name'] = 'Doe';


        //$result = $mailer->to(['emitz13@gmail.com' => 'Eric Mitkowski'])->replyTo('contact@wowmatcher.com', 'WowMatcher')->send('Hi there');

        $result = $mailer->type('customer_welcome')->to('emitz13@gmail.com')->pass($message_data)->send();

        xr($result);

        //Pigeon::type('customer_welcome')->to('emitz13@gmail.com')->pass($message_data)->send();

        //Pigeon::to('emitz13@gmail.com')->send('test');

        er('Mail Sent');
    }

}