<?php namespace App\Services\Support\Validator\User;

use App\Services\Support\Validator\ValidatorAbstract;

class EditValidator extends ValidatorAbstract
{

    /**
     * Validation rules
     */
    protected $rules = [
        'first_name' => 'required|alpha',
        'last_name' => 'required|alpha',
        'email' => 'required|email',
    ];

    /**
     * Custom Validation Messages
     */
    protected $messages = [
        'email.exists' => 'This :attribute is already in use with another account.',
    ];

}