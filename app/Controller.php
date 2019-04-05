<?php


namespace Framework;

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;

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
        extract($data);
        ob_start();
        require(__DIR__ . '/../templates/' . $view);
        $content = ob_get_clean();

        return new HtmlResponse($content);
    }

    /**
     * @param string $url
     * @return RedirectResponse
     */
    protected function redirect(string $url): RedirectResponse
    {
        return new RedirectResponse($url);
    }
}
