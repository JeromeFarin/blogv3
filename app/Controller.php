<?php
namespace Framework;

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest;

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

    /**
     * Create
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function add(ServerRequest $request)
    {
        $this->form->handle($request);
        
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->manager->insert($this->form->getData());
            return $this->flash->setFlash(['Chapter was created']);
        }

        return $this->flash->setFlash($this->form->getErrors());
    }

    /**
     * Modifie
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function edit(ServerRequest $request)
    {        
        $this->form->handle($request);
        
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->manager->update($this->form->getData());
            return $this->flash->setFlash(['Chapter was modified']);
        }

        return $this->flash->setFlash($this->form->getErrors());
    }

    /**
     * Delete
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function delete(ServerRequest $request)
    {
        $this->form->handle($request);
        
        if ($this->form->isSubmitted()) {
            $this->manager->delete($this->form->getData());
            return $this->flash->setFlash(['Chapter was deleted']);
        }

        return $this->flash->setFlash($this->form->getErrors());
    }
}
