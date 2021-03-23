<?php
/** @var \Laravel\Lumen\Routing\Router $router */
$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('/', function () {
        $error = new InvalidArgumentException('Method not allowed', 422);
        return responseHandler()->error($error);
    });

    $router->post('/', [
        'validate' => 'user',
        'middleware' => 'validate_field',
        'uses' => 'UserController@store']);

    $router->group(['prefix' => '{id}'], function ($router) {
        $router->get('/',         ['as' => 'user.get', 'uses' => 'UserController@get']);
        $router->get('/balance',  ['as' => 'user.balance', 'uses' => 'UserController@balance']);
        $router->post('/transfer',['as' => 'user.transfer', 'uses' => 'UserController@transfer']);
    });
});
