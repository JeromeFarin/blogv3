<?php

namespace Framework\Router;

use Symfony\Component\Yaml\Yaml;
use Zend\Diactoros\ServerRequest;
use Framework\Router\Route;

/**
 * Router class
 * @package Framework\Router
 */
class Router
{
    /**
     * Undocumented variable
     *
     * @var ServerRequest
     */
    private $request;

    /**
     * Constructor
     *
     * @param ServerRequest $request
     */
    public function __construct(ServerRequest $request) {
        $this->request = $request;
    }

    /**
     * Load .yml file
     *
     * @param string $file
     * @return void
     */
    public function loadYaml(string $file)
    {
        $routes = Yaml::parseFile($file);
        foreach ($routes as $name => $route) {
            $this->addRoute(new Route($name, $route["path"], $route["parameters"], $route["controller"], $route["action"], $route["defaults"] ?? []));
        }
    }

    /**
     * Create new route
     *
     * @param Route $route
     * @return void
     */
    public function addRoute(Route $route)
    {
        if(isset($this->routes[$route->getName()])) {
            throw new \Exception("Cette route existe déjà !");
        }
        $this->routes[$route->getName()] = $route;
    }

    /**
     * Get route by request send
     *
     * @return route
     */
    public function getRouteByRequest()
    {
        $request = preg_replace('/(\/)$/i','',$this->request->getUri()->getPath());

        if ($request == '') {
            $request = '/';
        }
        
        foreach($this->routes as $route) {
            if($route->match($request)) {
                return $route;
            }
        }
        
        throw new \Exception("Cette route n'existe pas !");
    }
}