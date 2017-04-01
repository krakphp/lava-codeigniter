<?php

use Krak\Lava;
use Krak\LavaCodeIgniter\CodeIgniterPackage;

require_once __DIR__ . '/../../vendor/autoload.php';

$_SERVER['SCRIPT_NAME'] = '/index.php';

function app($ci) {
    $app = new Lava\App();
    $app['debug'] = true;
    $app->with([
        new Lava\Package\RESTPackage(),
        new CodeIgniterPackage($ci),
    ]);

    $app->routes(function($routes) {
        $routes->get('/home', function() {
            return ['welcome_message', []];
        });
        $routes->get('/json', function() {
            return [1,2];
        });
        $routes->get('/exception', function($app) {
            throw new \InvalidArgumentException('hey');
        });
    });

    return $app;
}

chdir(__DIR__ . '/ci3');
require_once 'index.php';
