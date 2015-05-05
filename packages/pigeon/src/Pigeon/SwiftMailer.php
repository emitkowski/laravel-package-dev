<?php namespace Pigeon;

use ErrorException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


/**
 * Class SwiftMailer
 * @package Pigeon
 *
 * This class utilizes Laravel 5 Swift Mailer methods for a Pigeon Implementation
 *
 */
class SwiftMailer extends MessageAbstract implements PigeonInterface
{

    /**
     * Pretend On/Off
     *
     * @var bool
     */
    protected $pretend = false;

    /**
     * Swift Mailer Constructor
     *
     * @param MessageLayout $message_layout
     */
    public function __construct(MessageLayout $message_layout)
    {
        parent::__construct($message_layout);
    }

    /**
     * Send Mail
     *
     * @param null $raw_message
     * @return bool
     */
    public function send($raw_message = null)
    {
        // Set pretend value
        Mail::pretend($this->pretend);

        // Set Optional Message Data
        if (!is_null($raw_message)) {
            $send_result = $this->sendRawMessage($raw_message);
        } else {
            $send_result = $this->sendMessage();
        }

        // Turn pretend back to global config after send
        Mail::pretend(config('mail.pretend'));

        return $send_result;
    }


    /**
     * Send SwiftMail Message
     *
     * @return bool
     */
    private function sendMessage()
    {
        try {
            Mail::send($this->message_layout->getViewLayout(), $this->message_layout->getMessageVariables(), function ($message) {

                // Set message parts
                $message->to($this->to)
                    ->subject($this->subject)
                    ->cc($this->cc)
                    ->bcc($this->bcc);

                // Set all attachments
                foreach ($this->attachments as $a) {
                    $message->attach($a['path'], $a['options']);
                }

                $this->subjectWarning();
            });
        } catch (ErrorException $e) {
            $msg = 'SwiftMail could not send message: ' . $e->getMessage();
            Log::error($msg);
            return false;
        } catch (\Swift_TransportException $e) {
            $msg = 'SwiftMail SMTP is not working: ' . $e->getMessage();
            Log::error($msg);
            return false;
        }

        return true;
    }


    /**
     * Send SwiftMail Raw Message
     *
     * @param $message
     * @return bool
     */
    private function sendRawMessage($message)
    {
        try {
            Mail::raw($message, function ($message) {

                // Set message parts
                $message->to($this->to)
                    ->subject($this->subject)
                    ->cc($this->cc)
                    ->bcc($this->bcc);

                // Set all attachments
                foreach ($this->attachments as $a) {
                    $message->attach($a['path'], $a['options']);
                }

                $this->subjectWarning();
            });
        } catch (ErrorException $e) {
            $msg = 'SwiftMail could not send message: ' . $e->getMessage();
            dd($msg);
            Log::error($msg);
            return false;
        } catch (\Swift_TransportException $e) {
            $msg = 'SwiftMail SMTP is not working: ' . $e->getMessage();
            dd($msg);
            Log::error($msg);
            return false;
        }

        return true;
    }

    /**
     * Use Laravel pretend method and send mail to log file instead
     *
     * @param bool $value
     * @return PigeonAbstract
     */
    public function pretend($value = true)
    {
       $this->pretend = $value;

       return $this;
    }
}