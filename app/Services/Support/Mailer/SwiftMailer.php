<?php namespace App\Services\Support\Mailer;

/**
 * Class SwiftMailerAbstract
 * @package App\Services\Mailer
 *
 * This class defines abstract Swift Mailer methods
 *
 */
class SwiftMailer extends MailerAbstract implements MailerInterface
{

    /**
     * Pretend On/Off
     *
     * @var bool
     */
    protected $pretend = false;


    /**
     * Swift Mailer Abstract Constructor
     *
     * @param MailerLayout $mailer_layout
     */
    public function __construct(MailerLayout $mailer_layout)
    {
        $this->mailer_layout = $mailer_layout;
    }

    /**
     * Send Mail
     *
     * @param null $to
     * @param null $message_data
     * @return bool
     */
    public function send($to=null, $message_data=null)
    {

        // Set optional To
        if (!is_null($to)) {
            $this->to($to);
        }

        // Set Optional Message Data
        if (!is_null($message_data)) {
            $this->setMessageData($message_data);
        }

        // Set pretend value
        \Mail::pretend($this->pretend);

        \Mail::send($this->mailer_layout->getViewLayout(), $this->mailer_layout->getMessageData(), function($message)
        {
            // Set To and Subject
            $message->to($this->to)->subject($this->subject);

            // Set all CC
            foreach ($this->cc as $cc) {
                $message->cc($cc);
            }

            // Set all BCC
            foreach ($this->bcc as $bcc) {
                $message->bcc($bcc);
            }

            // Set all attachments
            foreach ($this->attachments as $a) {
                $message->attach($a['path'], $a['options']);
            }
        });

        // Turn pretend back to global config after send
        \Mail::pretend(\Config::get('mail.pretend'));

        return true;
    }

    /**
     * Use Laravel pretend method and send mail to log file instead
     *
     * @param bool $value
     * @return SwiftMailerAbstract
     */
    public function pretend($value = true)
    {
       $this->pretend = $value;

       return $this;
    }
}