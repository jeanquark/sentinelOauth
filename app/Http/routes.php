<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
});

Route::group(['middleware' => ['web', 'guest']], function() {
    Route::get('login', array('as' => 'login', 'uses' => 'SessionController@create'));
    Route::post('login', array('as' => 'session.store', 'uses' => 'SessionController@store'));

    Route::get('login/{provider}', 'AuthController@redirectToProvider');
    Route::get('login/callback/{provider}', 'AuthController@handleProviderCallback');

    Route::get('register', ['as' => 'register', 'uses' => 'RegistrationController@create']);
    Route::post('register', ['as' => 'register.store', 'uses' => 'RegistrationController@register']);
    Route::get('register/verify/{confirmationCode}', ['as' => 'register.confirmation', 'uses' => 'RegistrationController@confirm']);
    
    Route::get('reactivate/{hash}', ['as' => 'sentinel.reactivate.form', 'uses' => 'RegistrationController@resendActivationForm']);
    Route::post('reactivate/{hash}', ['as' => 'sentinel.reactivate.send', 'uses' => 'RegistrationController@resendActivation']);
    
    Route::get('forgot', ['as' => 'sentinel.forgot.form', 'uses' => 'RegistrationController@forgotPasswordForm']);
    Route::post('forgot', ['as' => 'sentinel.forgot.request', 'uses' => 'RegistrationController@sendResetPasswordEmail']);
    Route::get('reset/{id}/{code}', ['as' => 'sentinel.reset.form', 'uses' => 'RegistrationController@passwordResetForm']);
    Route::post('reset/{id}/{code}', ['as' => 'sentinel.reset.password', 'uses' => 'RegistrationController@resetPassword']);
});

Route::group(['middleware' => 'user'], function() {
    Route::get('logout', array('as' => 'logout', 'uses' => 'SessionController@logout'));
});

Route::group(['middleware' => 'mod'], function () {
	Route::get('admin', array('as' => 'admin', 'uses' => 'AdminController@index'));
});

Route::group(['middleware' => 'admin'], function () {
	Route::resource('admin/user', 'UserController');
	Route::post('admin/user/{user}/password', array('as' => 'admin.user.password', 'uses' => 'UserController@changePassword'));
	Route::post('admin/user/{user}/role', array('as' => 'admin.user.role', 'uses' => 'UserController@updateRole'));
	Route::post('admin/user/{user}/activation', array('as' => 'admin.user.activation', 'uses' => 'UserController@updateActivation'));

});