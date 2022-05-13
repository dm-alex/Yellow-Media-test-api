<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'user', 'as' => 'user.'], function () use ($router) {
    $router->group(['middleware' => 'guest', 'namespace' => 'Auth'], function () use ($router) {
        $router->post('/register', ['uses' => 'RegisterController@register', 'as' => 'register']);
        $router->post('/sign-in', ['uses' => 'AuthenticateController@signIn', 'as' => 'sign_in']);
        $router->addRoute(['POST', 'PATCH'], '/recover-password', ['uses' => 'PasswordResetLinkController@sendResetLinkEmail', 'as' => 'recover_password']);
    });

    $router->group(['middleware' => 'auth', 'as' => 'companies.'], function () use ($router) {
        $router->get('/companies', ['uses' => 'CompaniesController@index', 'as' => 'list']);
        $router->post('/companies', ['uses' => 'CompaniesController@create', 'as' => 'create']);
    });
});

$router->post('/password/reset', ['uses' => 'Auth\\NewPasswordController@reset', 'as' => 'password.reset']);
