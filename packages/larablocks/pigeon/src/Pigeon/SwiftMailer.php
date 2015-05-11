<?php namespace Larablocks\Pigeon;

use ErrorException;
use Illuminate\Config\Repository as Config;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Log;

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
     * Mailer instance
     *
     * @Illuminate\Support\Facades\Mail
     */
    private $mailer;

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
     * @param Mailer $mailer
     * @param Config $config
     */
    public function __construct(Mailer $mailer, MessageLayout $message_layout, Config $config)
    {
        $this->mailer = $mailer;

        parent::__construct($message_layout, $config);
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
        $this->mailer->pretend($this->pretend);

        // Set Optional Message Data
        if (!is_null($raw_message)) {
            $send_result = $this->sendRawMessage($raw_message);
        } else {
            $send_result = $this->sendMessage();
        }

        // Turn pretend back to global config after send
        $this->mailer->pretend($this->config->get('mail.pretend'));

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
            $send_result = $this->mailer->send($this->message_layout->getViewLayout(), $this->message_layout->getMessageVariables(), function ($message) {

                // Set message parts
                $message->to($this->to)
                    ->subject($this->subject)
                    ->cc($this->cc)
                    ->bcc($this->bcc);

                // Set all attachments
                foreach ($this->attachments as $a) {
                    $message->attach($a['path'], $a['options']);
                }
            });

        } catch (ErrorException $e) {
            $msg = 'SwiftMail could not send message: ' . $e->getMessage();
            //Log::error($msg);
            return false;
        } catch (\Swift_TransportException $e) {
            $msg = 'SwiftMail SMTP is not working: ' . $e->getMessage();
           // Log::error($msg);
            return false;
        }

        return $send_result;
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
            $send_result = $this->mailer->raw($message, function ($message) {

                // Set message parts
                $message->to($this->to)
                    ->subject($this->subject)
                    ->cc($this->cc)
                    ->bcc($this->bcc);

                // Set all attachments
                foreach ($this->attachments as $a) {
                    $message->attach($a['path'], $a['options']);
                }
            });
        } catch (ErrorException $e) {
            $msg = 'SwiftMail could not send message: ' . $e->getMessage();
            //Log::error($msg);
            return false;
        } catch (\Swift_TransportException $e) {
            $msg = 'SwiftMail SMTP is not working: ' . $e->getMessage();
           // Log::error($msg);
            return false;
        }

        return $send_result;
    }

    /**
     * Use Laravel pretend method and send mail to log file instead
     *
     * @param bool $value
     * @return PigeonAbstract
     */
    public function pretend($value = true)
    {
        if (!is_bool($value)) {
           return false;
        }

        $this->pretend = $value;

        return $this;
    }
}