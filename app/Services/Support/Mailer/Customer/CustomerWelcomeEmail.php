<?php namespace App\Services\Support\Mailer\Customer;

use App\Services\Support\Mailer\MailerLayout;
use App\Services\Support\Mailer\SwiftMailer;

/**
 * Class CustomerWelcomeEmail
 * @package App\Services\Mailer\Customer
 */
class CustomerWelcomeEmail extends SwiftMailer
{
    protected $template = 'emails.templates.customer.welcome';

    protected $subject = 'Welcome New Customer';


    public function __construct(MailerLayout $mailer_layout)
    {
        $mailer_layout->setViewTemplate($this->template);

        parent::__construct($mailer_layout);
    }

}