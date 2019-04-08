<?php
namespace Framework;

use Application\Controller;
use Framework;

class Router 
{
    public function route($requestG)
    {
        $request = trim($requestG->getUri()->getPath(),'/');

        if (strpos($request,'/')) {
            $request = substr($request,strpos($request,'/')+1);

            if ($request === 'logout') {
                return (new Controller\SecurityController())->logout();
            }
            
            if ($request === 'login') {
                return (new Controller\SecurityController())->login($requestG->getParsedBody());
            }

            if ($requestG->getMethod() === "POST") {
                if (isset($requestG->getParsedBody()['delete'])) {
                    return (new Controller\BookController())->delete($requestG);
                }
                return (new Controller\BookController())->persist($requestG);
            }

            if ($request === 'book') {
                return (new Controller\BookController())->list();
            }

            $param = substr($request,strpos($request,'/')+1);

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
