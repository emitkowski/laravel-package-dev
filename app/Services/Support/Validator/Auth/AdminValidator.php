<?php

namespace App\Services\Support\Validator\Auth;

use App\Services\Support\Validator\ValidatorAbstract;

class AdminValidator extends ValidatorAbstract
{

    /**
     * Validation rules
     */
    protected $rules = [
        'email' => 'required|email|exists:admin',
        'password' => 'required'
    ];

    /**
     * Custom Validation Messages
     */
    protected $messages = [
        'email.exists' => 'Invalid Account Information',
    ];

}