<?php namespace App\Services\Support\Validator;

interface ValidatorInterface
{


    /**
     * Run validation on input.
     *
     * @return boolean
     */
    public function passes();

    /**
     * Get all errors stored.
     *
     * @return MessageBag
     */
    public function getErrors();

    /**
     * Add new error.
     *
     * @param $key
     * @param $message
     * @return MessageBag
     */
    public function addError($key, $message);

}