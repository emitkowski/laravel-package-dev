<?php namespace App\Services\Support\Mailer;


class MailerLayout
{

    /**
     * Constant representing a variable that will hold the message data in email view if data is not an array.
     *
     */
    const MESSAGE_VARIABLE = '_message';

    /**
     * Constant representing a variable that will hold the template path in email view.
     */
    const TEMPLATE_VARIABLE = '_template';

    /**
     * Email Layout View Path
     *
     * @var string
     */
    protected $view_layout = 'emails.layouts.default';

    /**
     * Email Template View Path
     *
     * @var
     */
    protected $view_template = 'emails.templates.default';


    /**
     * Email Message Data
     *
     * @var
     */
    protected $message_data;


    /**
     *
     */
    public function __construct()
    {
    }


    /**
     * Set Email View Layout
     *
     * @param $view
     */
    public function setViewLayout($view)
    {
        $this->view_layout = $view;
    }


    /**
     * Set Email View Template
     *
     * @param $template
     */
    public function setViewTemplate($template)
    {
        $this->view_template = $template;

        $this->assignTemplate();
    }


    /**
     * Set Message data
     *
     * @param $message_data
     */
    public function setMessageData($message_data)
    {
        $this->processMessageData($message_data);
    }

    /**
     * Get Email View Layout
     *
     * @return mixed
     */
    public function getViewLayout()
    {
        return $this->view_layout;
    }

    /**
     * Get Email View Template
     *
     * @return mixed
     */
    public function getViewTemplate()
    {
        return $this->view_template;
    }

    /**
     * Get Email Message Data
     *
     * @return mixed
     */
    public function getMessageData()
    {
        return $this->message_data;
    }


    /**
     * Assign the template variable into body data
     *
     */
    private function assignTemplate()
    {
        $this->message_data['_template'] = $this->view_template;
    }

    /**
     * Process Message for passing to view
     *
     * @param $message_data
     */
    private function processMessageData($message_data)
    {
        if (!is_array($message_data)) {
            $this->message_data[MailerLayout::MESSAGE_VARIABLE] = $message_data;
        } else {
            $this->message_data = $message_data;
            $this->assignTemplate();
        }
    }

}