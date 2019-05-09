<?php

namespace Framework\Router;

use Symfony\Component\Yaml\Yaml;
use Zend\Diactoros\ServerRequest;
use Framework\Router\Route;

class Router
{
    private $request;

    public function __construct(ServerRequest $request) {
        $this->request = $request;
    }

    public function loadYaml($file)
    {
        $routes = Yaml::parseFile($file);
        foreach ($routes as $name => $route) {
            $this->addRoute(new Route($name, $route["path"], $route["parameters"], $route["controller"], $route["action"], $route["defaults"] ?? []));
        }
    }

    public function addRoute(Route $route)
    {
        if(isset($this->routes[$route->getName()])) {
            throw new \Exception("Cette route existe déjà !");
        }
        $this->routes[$route->getName()] = $route;
    }

    public function getRouteByRequest()
    {
        $request = $this->request->getUri()->getPath();
        $request = substr($request,strpos($request,'/',1));
        if ($request[strlen($request) - 1] === "/") {
            $request = substr($request,0,strlen($request) - 1);
            if (empty($request)) {
                $request = '/';
            }
        }

        foreach($this->routes as $route) {
            if($route->match($request)) {
                return $route;
            }
        }
        
        throw new \Exception("Cette route n'existe pas !");
    }
}