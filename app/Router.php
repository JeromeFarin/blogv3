<?php
namespace Framework;

use Zend\Diactoros\ServerRequest;

class Router 
{
    private $requestG;
    private $container;

    /**
     * Contructor
     *
     * @param ServerRequest $requestG
     * @param Container $container
     */
    public function __construct(ServerRequest $requestG, Container $container) {
        $this->requestG = $requestG;
        $this->container = $container;
    }

    /**
     * Route
     *
     * @return void
     */
    public function route()
    {
        $request = $this->requestG->getUri()->getPath();
        
        if (substr($request,-1) !== '/') {
            $request = $request.'/';
        }

        $parameters = [];

        while ($request) {
            if (strpos($request,'/')) {
                array_push($parameters,substr($request,0,strpos($request,'/')));
            } else {
                array_push($parameters,$request);
            }
            $request = substr($request,strpos($request,'/')+1);
        }
        if (!isset($parameters[2])) {
            return $this->container->get("Application\Controller\DefaultController")->home();
        }

        if ($parameters[2] === 'admin') {
            if (isset($parameters[3])) {
                if ($parameters[3] === 'content') {
                    $action = $parameters[3];
                    return $this->container->get("Application\Controller\Manage\ChapterController")->$action($this->requestG);
                }

                $action = $parameters[3];
                return $this->container->get("Application\Controller\Manage\\".ucfirst($parameters[3])."Controller")->$action($this->requestG);
            } else {
                $action = 'panel';
                return $this->container->get("Application\Controller\\".ucfirst($parameters[2])."Controller")->$action($this->requestG);
            }
        }

        if ($parameters[2] === 'logout' || $parameters[2] === 'login') {
            $action = $parameters[2];
            return $this->container->get("Application\Controller\UserController")->$action($this->requestG);
        }

        if (isset($parameters[3])) {
            if (is_numeric($parameters[3])) {
                $action = $parameters[2];
                return $this->container->get("Application\Controller\\".ucfirst($parameters[2])."Controller")->$action($this->requestG,$this->container);
            }
        } else {
            $action = 'list';
            return $this->container->get("Application\Controller\\".ucfirst($parameters[2])."Controller")->$action();
        }
        throw new \Exception("Page not Found");
    }
}
