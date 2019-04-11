<?php
session_start();

use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$request = ServerRequestFactory::fromGlobals();

try {
    $router = new Framework\Router();
    $response = $router->route($request);

    $emitter = new SapiEmitter();

    $emitter->emit($response);
} catch (\Exception $e) {
    echo $e->getmessage();
}