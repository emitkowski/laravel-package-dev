<?php

namespace App\Providers;

use App\Repositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register the binding
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        /**** Admin Repository ***/
        $app->bind('AdminRepositoryEloquent', function () {
            return new Repositories\Admin\AdminRepositoryEloquent;
        });
        // Choose Binding
        $app->bind('App\Repositories\Admin\AdminRepositoryInterface', 'AdminRepositoryEloquent');


        /**** User Repository ***/
        $app->bind('UserRepositoryEloquent', function () {
            return new Repositories\User\UserRepositoryEloquent;
        });
        // Choose Binding
        $app->bind('App\Repositories\User\UserRepositoryInterface', 'UserRepositoryEloquent');

    }

}