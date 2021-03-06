<?php namespace App\Services\Support\Validator\User;

use App\Services\Support\Validator\ValidatorAbstract;

class APIValidator extends ValidatorAbstract
{

    /**
     * Validation rules
     */
    protected $rules = array(
        'first_name' => 'sometimes|alpha',
        'last_name' => 'required|alpha',
        'email' => 'required|email',
        'state' => 'alpha|size:2',
        'zip' => 'digits_between:5,10',
        'phone' => 'alpha_dash'
    );

}