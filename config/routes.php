<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::scope('/data-tables', function (RouteBuilder $routes) {
    if (!$routes->nameExists('data-tables:index:index')) {
        $routes->connect('/length', 'DataTables.Index::length', ['_name' => 'data-tables:index:index']);
        $routes->connect('/start', 'DataTables.Index::start', ['_name' => 'data-tables:index:index']);
    }
});