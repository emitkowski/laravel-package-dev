<?php namespace Pigeon;

use Illuminate\Support\Facades\Log;

/**
 * Class MessageAbstract
 * @package Pigeon
 *
 * This class holds the general mailing functions that would be used to create email using Pigeon
 *
 */
abstract class MessageAbstract
{
    /**
     * Message Layout instance
     *
     * @MailerLayout
     */
    protected $message_layout;

    /**
     * Message Type
     *
     * Used for setting a particular message type to utilize message configs
     *
     * @var string
     */
    protected $message_type = 'default';

    /**
     * Subject
     *
     * @string
     */
    protected $subject;

    /**
     * To Addresses
     *
     * @string
     */
    protected $to = [];

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
     * @param MessageLayout $message_layout
     */
    public function __construct(MessageLayout $message_layout)
    {
        $this->message_layout = $message_layout;
        $this->setDefaultConfigs();
    }


    /**
     * Set Message Type
     *
     * @param $message_type (config string)
     * @return $this
     */
    public function type($message_type)
    {
        try {
            $this->processMessageTypeConfigs($message_type);
        } catch (InvalidMessageTypeException $e) {
            Log::error($e->message());
        }

        return $this;
    }


    /**
     * Get Message Type
     *
     * @return null
     */
    public function getType()
    {
       return $this->message_type;
    }

    /**
     * Set Email Layout
     *
     * @param $layout_path
     * @return $this|object
     */
    public function layout($layout_path)
    {
        $this->message_layout->setViewLayout($layout_path);

        return $this;
    }


    /**
     * Set Email Template
     *
     * @param $template_path
     * @return $this|object
     */
    public function template($template_path)
    {
        $this->message_layout->setViewTemplate($template_path);

        return $this;
    }


    /**
     * Set To
     *
     * @param $address
     * @return $this
     */
    public function to($address)
    {
        if (is_array($address)) {
            $this->addAddressArray($address, 'to');
        } else {
            array_push($this->to, $address);
        }

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
        if (is_array($address)) {
            $this->addAddressArray($address, 'cc');
        } else {
            array_push($this->cc, $address);
        }

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
        if (is_array($address)) {
            $this->addAddressArray($address, 'bcc');
        } else {
            array_push($this->bcc, $address);
        }

        return $this;
    }


    /**
     * Pass Message variables
     *
     * @param array $message_variables
     * @return $this
     */
    public function pass(array $message_variables)
    {
        $this->message_layout->includeVariables($message_variables);

        return $this;
    }


    /**
     * Clear All Message Variables Assigned (except template)
     *
     * @return $this
     */
    public function clear()
    {
        $this->message_layout->clearVariables();

        return $this;
    }

    /**
     * Attaches file to mail
     *
     * @param $pathToFile
     * @param array $options
     * @return $this|object
     */
    public function attach($pathToFile, array $options = [])
    {
        $attachment['path'] = base_path().$pathToFile;
        $attachment['options'] = $options;

        array_push($this->attachments, $attachment);

        return $this;
    }

    /**
     * Log Warning if subject is not set
     *
     */
    protected function subjectWarning()
    {
        if (empty($this->subject) || $this->subject === '') {
            Log::warning('Pigeon sent a message without a subject.');
        }
    }


    /**
     * Adds array of addresses to type
     *
     * @param array $address_array
     * @param $type
     * @return bool
     */
    private function addAddressArray(array $address_array, $type)
    {
        foreach ($address_array as $address) {
            if ($type === 'to') {
                $this->to($address);
            } else if ($type === 'cc') {
                $this->cc($address);
            } else if ($type === 'bcc') {
                $this->bcc($address);
            } else {
                // Invalid Address Type
            }
        }

        return true;
    }

    /**
     * Set Default Configuration for Message
     *
     * @throws UnknownMessageTypeException
     */
    private function setDefaultConfigs()
    {
        $config_string = 'pigeon.default';

        $message_config = config($config_string);

        if (is_null($message_config)) {
            throw new UnknownMessageTypeException('default');
        }

        $this->setConfigOptions($config_string);
    }


    /**
     * Check the configs for message type and then assign if valid
     *
     * @param $message_type
     * @throws InvalidMessageTypeException
     * @throws UnknownMessageTypeException
     */
    private function processMessageTypeConfigs($message_type)
    {
        $config_string = 'pigeon.message_types.'.$message_type;

        $message_config = config($config_string);

        if (is_null($message_config)) {
            throw new UnknownMessageTypeException($message_type);
        }

        if (!is_array($message_config)) {
            throw new InvalidMessageTypeException($message_type);
        }

        if($this->setConfigOptions($config_string)) {
            $this->message_type = $message_type;
        }

    }

    /**
     * Set Configuration Options
     *
     * @param $config_string
     * @return bool
     */
    private function setConfigOptions($config_string)
    {
        $subject_config = config($config_string.'.subject');
        if (isset($subject_config)) {
            $this->subject($subject_config);
        }

        $layout_config = config($config_string.'.layout');
        if (isset($layout_config)) {
            $this->layout($layout_config);
        }

        $template_config = config($config_string.'.template');
        if (isset($template_config)) {
            $this->template($template_config);
        }

        $to_config = config($config_string.'.to');
        if (isset($to_config)) {
            $this->to($to_config);
        }

        $cc_config = config($config_string.'.cc');
        if (isset($cc_config)) {
            $this->cc($cc_config);
        }

        $bcc_config = config($config_string.'.bcc');
        if (isset($bcc_config)) {
            $this->bcc($bcc_config);
        }

        $message_variables_config = config($config_string.'.message_variables');
        if (isset($message_variables_config)) {
            $this->pass($message_variables_config);
        }

        return true;
    }
}