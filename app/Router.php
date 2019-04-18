<?php
namespace Framework;

use Application\Controller;

class Router 
{
    public function route($requestG)
    {
        $request = trim($requestG->getUri()->getPath(),'/');

        if (strpos($request,'/')) {
            $request = substr($request,strpos($request,'/')+1);

            if ($request === 'logout') {
                return (new Controller\UserController())->logout();
            }
            
            if ($request === 'login') {
                return (new Controller\UserController())->login($requestG);
            }

            if ($request === 'book') {
                return (new Controller\BookController())->list($requestG);
            }

            $param = substr($request,strpos($request,'/')+1);

            if (strpos($param,'/')) {
                throw new \Exception("Not Valid Param");
            }

            if (is_numeric($param)) {
                return (new Controller\BookController())->book($param,$requestG);
            }

            throw new \Exception("Page not Found");
        }
        return (new Controller\DefaultController())->home();
    }
}
