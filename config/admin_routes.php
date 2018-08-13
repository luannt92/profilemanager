<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::prefix(
    'admin', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Users', 'action' => 'login']);

    $routes->fallbacks(DashedRoute::class);
});
