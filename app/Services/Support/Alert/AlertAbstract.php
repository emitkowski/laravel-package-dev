<?php namespace App\Services\Support\Alert;

/**
 * Class AlertAbstract
 * @package App\Services\Support\Alert
 *
 * This class defines the abstract Alert Service
 *
 */
abstract class AlertAbstract
{
    // Mailer Object
    protected $mailer;

    // Alert Settings
    protected $email_enabled;
    protected $text_enabled;

    // Alert Message Properties
    protected $alert_email;
    protected $alert_level;
    protected $subject_header;

    /**
     * Alert Abstract Constructor
     *
     */
    public function __construct()
    {
        $this->email_enabled = (bool) config('support.alert.enabled.email');
        $this->text_enabled = (bool) config('support.alert.enabled.text');
    }

    /**
     * Abstract Alert Method
     *
     * @param $subject
     * @param $message
     * @param $alert_level
     * @param $contacts
     * @return
     */
    abstract public function alert($subject, $message, $alert_level=null, $contacts=null);

    /**
     * Send Alert Email
     *
     * @param $subject
     * @param $message
     * @param null $alert_level
     * @param null $contacts
     * @return bool
     */
    protected function emailAlert($subject, $message, $alert_level=null, $contacts=null)
    {
        // Check if email enabled
        if($this->email_enabled) {

            // Check for optional email override
            /*if (is_array($contacts)) {
                $this->alert_email = $contacts;
            } else {
                $this->alert_email = $contacts;
            }*/

            // Check for optional alert level override
            if (!is_null($alert_level)) {
                $this->alert_level = $alert_level;
            }

            // Set mailer to
            $this->mailer->to($this->alert_email);

            // Finish mail build and send
            $this->mailer->subject($subject)->setMessageData($message)->send();
        }

        return true;
    }

    /**
     * Send Alert Text
     *
     * @param $message
     * @param null $alert_level
     * @param null $contacts
     * @return bool
     */
    protected function textAlert($message, $alert_level=null, $contacts=null)
    {
        return true;
    }



}