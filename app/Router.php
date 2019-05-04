<?php
namespace Framework;

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
                    return $this->container->get('Application\Controller\Manage\BookController')->book($this->requestG);
                }

                if ($param === 'chapter') {
                    return $this->container->get('Application\Controller\Manage\ChapterController')->chapter($this->requestG);
                }

                if ($param === 'user') {
                    return $this->container->get('Application\Controller\Manage\UserController')->user($this->requestG);
                }

                if ($param === 'comment') {
                    return $this->container->get('Application\Controller\Manage\CommentController')->comment($this->requestG);
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
                return $this->container->get('Application\Controller\BookController')->list();
            }
            
            if (strpos('/'.$param,'content')) {
                return $this->container->get('Application\Controller\Manage\ChapterController')->content($this->requestG);
            }

            if (strpos($param,'/')) {
                throw new \Exception("Not Valid Param");
            }

            if (is_numeric($param) && strpos('/'.$request,'book')) {
                return $this->container->get('Application\Controller\BookController')->book($param);
            }
            if (is_numeric($param) && strpos('/'.$request,'chapter')) {
                return $this->container->get('Application\Controller\ChapterController')->chapter($this->requestG);
            }

            throw new \Exception("Page not Found");
        }
        return $this->container->get('Application\Controller\DefaultController')->home();
    }
}
