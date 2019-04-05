<?php
namespace Framework;

use Zend\Diactoros\Response\HtmlResponse;
use Application\Controller;

class Router 
{
    public function route($requestG)
    {
        $request = trim($requestG->getUri()->getPath(),'/');

        if (strpos($request,'/')) {
            $request = substr($request,strpos($request,'/')+1);

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

            // var_dump($param);

            throw new \Exception("Page not Found");
        }

        return (new Controller\DefaultController())->home();
    }
}
