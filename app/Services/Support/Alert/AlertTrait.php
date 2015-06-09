<?php

namespace App\Services\Support\Alert;

trait AlertTrait
{

    /**
     * Webops Alert
     * @param $subject
     * @param $message
     * @param null $alert_level
     * @param null $contacts
     */
    protected function webopsAlert($subject, $message, $alert_level=null, $contacts=null)
    {
        $alert = \App::make('WebopsAlert');
        $alert->alert($subject, $message, $alert_level, $contacts);
    }
}