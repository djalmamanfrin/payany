<?php
/** @var \Laravel\Lumen\Routing\Router $router */
$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('/', function () {
        $error = new InvalidArgumentException('Method not allowed', 422);
        return responseHandler()->error($error);
    });
    $router->post('/', [ 'uses' => 'UserController@store']);
    $router->group(['prefix' => '{id}'], function ($router) {
        $router->get('/',          ['uses' => 'UserController@get']);
        $router->get('/balance',   ['uses' => 'UserController@balance']);
        $router->post('/transfer', ['uses' => 'UserController@transfer']);
    });
});
