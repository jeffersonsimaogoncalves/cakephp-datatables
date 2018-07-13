<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::scope('/data-tables', function (RouteBuilder $routes) {
    if (!$routes->nameExists('data-tables:index:index')) {
        $routes->connect('/length', 'DataTables.Index::length');
        $routes->connect('/start', 'DataTables.Index::start');
    }
});