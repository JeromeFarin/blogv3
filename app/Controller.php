<?php
namespace Framework;

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Application\Manager\UserManager;

class Controller
{
    /**
     * @param string $model
     * @return Manager
     */
    protected function getManager(string $model): Manager
    {
        $manager = $model::getInfo()["manager"];

        return new $manager();
    }

    /**
     * @param string $view
     * @param array $data
     * @return HtmlResponse
     */
    protected function render(string $view, array $data = []): HtmlResponse
    {
        // extract($data);
        // ob_start();
        // require(__DIR__ . '/../templates/' . $view);
        // $htmlContent = ob_get_clean();

        $loader = new \Twig_Loader_Filesystem('../templates');
        $twig = new \Twig_Environment($loader, array(
            'cache' => false
        ));
        $twig->addGlobal('session', $_SESSION);
        if (isset($_SESSION['mail']) && isset($_SESSION['pass'])) {
            $check = (new UserManager())->check($_SESSION);
            if ($check != false) {
                $twig->addGlobal('check',true);
            }
        }

        $htmlContent = $twig->render($view, $data);
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
