<?php
namespace Framework;

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Controller class
 * @package Framework
 */
class Controller
{
    /**
     * @param string $model
     * @return Manager
     */
    public function getManager(string $model): Manager
    {
        $manager = $model::getInfo()["manager"];

        return new $manager();
    }

    /**
     * @param string $view
     * @param array $data
     * @return mixed
     */
    public function render(string $view, array $data = [], bool $call = false)
    {
        $container = new Container();
        $loader = new \Twig_Loader_Filesystem('../templates');
        $twig = new \Twig_Environment($loader, array(
            'cache' => false
        ));
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('messages', $container->get('Framework\FlashBag')->getFlash());
        if (isset($_SESSION['mail']) && isset($_SESSION['pass'])) {
            $check = $container->get('Application\Controller\UserController')->loginAuto();
            if ($check === true) {
                $twig->addGlobal('check',true);
            }
        }

        $htmlContent = $twig->render($view, $data);
        
        if ($call) {
            return $htmlContent;
        }

        return new HtmlResponse($htmlContent);
    }

    /**
     * @param string $url
     * @return RedirectResponse
     */
    public function redirect(string $url): RedirectResponse
    {
        return new RedirectResponse($url);
    }
}
