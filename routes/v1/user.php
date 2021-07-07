<?php
/** @var \Laravel\Lumen\Routing\Router $router */
$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('/', function () {
        $error = new InvalidArgumentException('Method not allowed', 422);
        return responseHandler()->error($error);
    });
    $router->post('/', [ 'uses' => 'TransferDispatchAction@store']);
    $router->group(['prefix' => '{id}'], function ($router) {
        $router->get('/',          ['uses' => 'UserGetAction@get']);
        $router->get('/balance',   ['uses' => 'WalletGetBalanceAction@balance']);
        $router->post('/transfer', ['uses' => 'TransferDispatchAction@transfer']);
    });
});
