<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
 * Development Routes
 */

// Environment Detection
Route::get('env', function()
{
	dd(App::environment());
});

// PHP Info
Route::get('info', function() {
    if (App::environment() != 'production') {
        phpinfo();
    }
});


/*
 * Frontend Routes
 */

Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');


Route::controllers([
    'api-test' => 'Auth\AuthController',
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
    'billing' => 'Examples\BillingController',
    'mailer' => 'Examples\MailerController',
    'test' => 'Examples\TestController'
]);

/*
 *  API Routes
 */
Route::group(['prefix' => 'api'], function() {

    Route::get('/user/search', array('uses' => 'API\V1\UserAPIController@search'));

    Route::resources([
        'user' => 'API\V1\UserAPIController'
    ]);

});

/*
 *  Admin Routes
 */

Route::group(array('prefix' => 'admin'), function()
{
	Route::any('login', array('as' => 'adminlogin', 'uses' => 'Admin\AuthAdminController@adminLogin'))->before('guest');

	Route::group(array('before' => 'auth'), function()
	{
		Route::any('/', array('as' => 'adminhome', 'uses' => 'Admin\UserAdminController@index'));

		// Logout Route
		Route::any('logout', array('as' => 'adminlogout', 'uses' => 'Admin\AuthAdminController@adminLogout'));

	});
});