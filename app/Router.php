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

            $param = substr($request,strpos($request,'/')+1);
            
            if (isset($_SESSION['mail']) && strpos('/'.$request,'admin')) {
                if ($param === 'book') {
                    return (new Controller\AdminController())->book($requestG);
                }

                if ($param === 'chapter') {
                    return (new Controller\AdminController())->chapter($requestG);
                }

                return (new Controller\AdminController())->panel();
            }
            if ($request === 'logout') {
                return (new Controller\UserController())->logout();
            }
            
            if ($request === 'login') {
                return (new Controller\UserController())->login($requestG);
            }

            if ($request === 'book') {
                return (new Controller\BookController())->list();
            }

            if (strpos($param,'/')) {
                throw new \Exception("Not Valid Param");
            }

            if (is_numeric($param)) {
                return (new Controller\BookController())->book($param);
            }

            throw new \Exception("Page not Found");
        }
        return (new Controller\DefaultController())->home();
    }
}
