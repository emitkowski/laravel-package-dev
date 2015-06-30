<?php

namespace App\Services\Support\Validator;

use Illuminate\Support\MessageBag as MessageBag;

/*
 * This class defines abstract Validator methods
 */

abstract class ValidatorAbstract implements ValidatorInterface
{

    protected $validator;
    protected $input;
    protected $errors;

    protected $rules = [];
    protected $messages = [];


    /**
     * @param array $input
     * @param \Illuminate\Support\MessageBag $bag
     */
    public function __construct($input = null, MessageBag $bag)
    {
        $this->input = $input ?: \Request::all();

        $this->validator = \Validator::make($this->input, $this->rules, $this->messages);
        $this->errors = $bag;
    }

    /**
     * Run validation on input.
     *
     * @return boolean
     */
    public function passes()
    {
        if ($this->validator->passes()) {
            return true;
        }

        $this->errors = $this->validator->messages();

        return false;
    }

    /**
     * Get all errors stored.
     *
     * @return MessageBag
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Add new error.
     *
     * @param $key
     * @param $message
     * @return MessageBag
     */
    public function addError($key, $message)
    {
        return $this->errors->add($key, $message);
    }

}