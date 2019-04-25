<?php
namespace Framework;

use Application\Controller;
use Application\Controller\BookController;

class Router 
{
    private $requestG;
    private $container;

    public function __construct($requestG,$container) {
        $this->requestG = $requestG;
        $this->container = $container;
    }
    public function route()
    {
        $request = trim($this->requestG->getUri()->getPath(),'/');

        if (strpos($request,'/')) {
            $request = substr($request,strpos($request,'/')+1);

            $param = substr($request,strpos($request,'/')+1);
            
            if (isset($_SESSION['mail']) && strpos('/'.$request,'admin')) {
                if ($param === 'book') {
                    return $this->container->get('Application\Controller\AdminController')->book($this->requestG);
                }

                if ($param === 'chapter') {
                    return $this->container->get('Application\Controller\AdminController')->chapter($this->requestG);
                }

                return $this->container->get('Application\Controller\AdminController')->panel();
            }
            if ($request === 'logout') {
                return $this->container->get('Application\Controller\UserController')->logout();
            }
            
            if ($request === 'login') {
                return $this->container->get('Application\Controller\UserController')->login($this->requestG);
            }

            if ($request === 'book') {
                $this->container->set('Application\Controller\BookController',function($container){
                    return new BookController($container);
                });
                
                return $this->container->get('Application\Controller\BookController')->list();
            }

            if (strpos($param,'/')) {
                throw new \Exception("Not Valid Param");
            }

            if (is_numeric($param)) {
                $this->container->set('Application\Controller\BookController',function($container){
                    return new BookController($container);
                });

                return $this->container->get('Application\Controller\BookController')->book($param);
            }

            throw new \Exception("Page not Found");
        }
        return $this->container->get('Application\Controller\DefaultController')->home();
    }
}
