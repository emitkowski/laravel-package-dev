<?php namespace App\Services\Support\Mailer;


/**
 * Class MailerAbstract
 * @package App\Services\Support\Mailer
 *
 * This class defines abstract Mailer methods
 *
 */
abstract class MailerAbstract implements MailerInterface
{
    /**
     * Mailer Layout instance
     *
     * @MailerLayout
     */
    protected $mailer_layout;

    /**
     * Subject
     *
     * @string
     */
    protected $subject;

    /**
     * To
     *
     * @string
     */
    protected $to;

    /**
     * CC Addresses
     *
     * @string array
     */
    protected $cc = [];

    /**
     * BCC Addresses
     *
     * @string array
     */
    protected $bcc = [];

    /**
     * File Attachments
     *
     * @string array
     */
    protected $attachments = [];


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
     * Set Email Layout
     *
     * @param $layout_path
     * @return $this|object
     */
    public function setLayout($layout_path)
    {
        $this->mailer_layout->setViewLayout($layout_path);

        return $this;
    }


    /**
     * Set Email Template
     *
     * @param $template_path
     * @return $this|object
     */
    public function setTemplate($template_path)
    {
        $this->mailer_layout->setViewTemplate($template_path);

        return $this;
    }


    /**
     * Set To
     *
     * @param $email_address
     * @return $this
     */
    public function to($email_address)
    {
        $this->to = $email_address;

        return $this;
    }

    /**
     * Set Subject
     *
     * @param $subject
     * @return $this|object
     */
    public function subject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Adds a Carbon Copy(CC) address
     *
     * @param $address
     * @return $this|object
     */
    public function cc($address)
    {
        array_push($this->cc, $address);

        return $this;
    }

    /**
     * Adds a Blind Carbon Copy(BCC) address
     *
     * @param $address
     * @return $this|object
     */
    public function bcc($address)
    {
        array_push($this->bcc, $address);

        return $this;
    }


    /**
     * Set Message data
     *
     * @param $message_data
     * @return $this
     */
    public function setMessageData($message_data)
    {
        $this->mailer_layout->setMessageData($message_data);

        return $this;
    }

    /**
     * Attaches file to mail
     *
     * @param $pathToFile
     * @param array $options
     * @return $this|object
     */
    public function attach($pathToFile, $options = array())
    {
        $attachment['path'] = base_path().$pathToFile;
        $attachment['options'] = $options;

        array_push($this->attachments, $attachment);

        return $this;
    }
}