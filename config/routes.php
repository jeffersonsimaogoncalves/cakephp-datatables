<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::scope('/data-tables', function (RouteBuilder $routes) {
    $routes->connect('/length', 'DataTables.Index::length');
    $routes->connect('/start', 'DataTables.Index::start');
});