<?php
session_start();

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Debug\DebugClassLoader;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Container;
use Framework\Router;
use Application\Controller\BookController;

require __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

if (is_file(__DIR__ . '/../.env.local')) {
    $dotenv->overload(__DIR__ . '/../.env.local');
}

if (getenv("APP_ENV") === "dev") {
    Debug::enable();
    ErrorHandler::register();
    ExceptionHandler::register();
    DebugClassLoader::enable();
}

$container = new Container();

$container->set('Framework\Router',function($container){
    $request = ServerRequestFactory::fromGlobals();
    
    return new Router($request,$container);
});

$router = $container->get('Framework\Router');

$response = $router->route();

$emitter = new SapiEmitter();

$emitter->emit($response);
