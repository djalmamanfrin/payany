<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('alive', function () {
        return ['status' => true, 'message' => "I'm Alive"];
    });
    include('v1/v1.php');
});
