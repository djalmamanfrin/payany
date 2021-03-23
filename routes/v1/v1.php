<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'v1', 'namespace' => 'V1'], function () use ($router) {
    $router->group(['namespace' => 'User'], function () use ($router) {
        include('user.php');
    });
});
