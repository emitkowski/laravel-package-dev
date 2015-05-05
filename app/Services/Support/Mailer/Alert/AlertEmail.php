<?php namespace App\Services\Support\Mailer\Alert;

use App\Services\Support\Mailer\SwiftMailer;


class AlertEmail extends SwiftMailer
{
    protected $layout = 'emails.layouts.alert';

    protected $template = 'emails.templates.alert.standard';
}