<?php namespace App\Services\Support\Mailer;

/**
 * Interface MailerInterface
 * @package App\Services\Support\Mailer
 */
interface MailerInterface
{

    /**
    * Sends mail
    *
    * @return boolean
    */
    public function send();

    /**
     * Set Email Layout
     *
     * @param $layout_path
     * @return object
     */
    public function setLayout($layout_path);

    /**
     * Set Email Template
     *
     * @param $template_path
     * @return object
     */
    public function setTemplate($template_path);

    /**
     * Set To Address
     *
     * @param $email_address
     * @return mixed
     */
    public function to($email_address);

    /**
     * Set Email Subject
     *
     * @param $subject
     * @return object
     */
    public function subject($subject);

    /**
     * Adds a Carbon Copy(CC) address
     *
     * @param $address
     * @return object
     */
    public function cc($address);

    /**
     * Adds a Blind Carbon Copy(BCC) address
     *
     * @param $address
     * @return object
     */
    public function bcc($address);

    /**
     * Set Message Data
     *
     * @param $message_data
     * @return mixed
     */
    public function setMessageData($message_data);

    /**
     * Attaches file to mail
     *
     * @param $pathToFile
     * @return object
     */
    public function attach($pathToFile);

}