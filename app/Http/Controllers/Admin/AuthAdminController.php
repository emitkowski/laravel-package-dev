<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

use App\Repositories\User\UserRepositoryInterface as UserRepositoryInterface;
use App\Repositories\Admin\AdminRepositoryInterface as AdminRepositoryInterface;
use App\Services\Validator\Auth\AdminValidator;

class AuthAdminController extends Controller {

    protected $user_repo;
    protected $admin_repo;
    protected $admin_auth_validator;

    public function __construct(UserRepositoryInterface $user_repo, AdminRepositoryInterface $admin_repo, AdminValidator $admin_auth_validator)
    {
        $this->user_repo = $user_repo;
        $this->admin_repo = $admin_repo;
        $this->admin_auth_validator = $admin_auth_validator;
    }

    public function adminLogin()
    {
        $input = \Input::all();

        if(!empty($input))
        {
            if($this->admin_auth_validator->passes())
            {
                if(\Auth::attempt(array('email' => $input['email'], 'password' => $input['password'], 'active' => true)))
                {
                    return \Redirect::to('admin/users');
                }
                else
                {
                    $this->admin_auth_validator->addError('password', 'Invalid Account Information');
                }
            }

        }

        return view('admin.auth.adminlogin')->withErrors($this->admin_auth_validator->getErrors());
    }

    public function adminLogout()
    {
       \ Auth::logout();

        return \Redirect::route('adminhome');
    }

}