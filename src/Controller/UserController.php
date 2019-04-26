<?php
namespace Application\Controller;

use Framework\Controller;
use Application\Form\User\AddForm;

class UserController extends Controller
{
    private $model;
    private $handler;
    private $form;

    public function __construct(\Application\Model\User $model,\Application\Handler\UserHandler $handler, \Application\Form\User\AddForm $form) {
        $this->model = $model;
        $this->handler = $handler;
        $this->form = $form;
    }
    public function login($request)
    {
        if (isset($_SESSION['mail']) && isset($_SESSION['pass'])) {

            $this->model->setMail($_SESSION['mail']);
            $this->model->setPass($_SESSION['pass']);

            return $this->handler->login($this->model,$request);
        }

        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->handler->login($this->form->getData(),$request);
            return $this->redirect('/blogv3');
        }

        return $this->render('user/login.twig', array(
            'title' => 'Connection',
            'form' => $this->form
        ));
    }

    public function logout()
    {
        $result = $this->handler->logout();
        if ($result) {
            return $this->redirect('/blogv3');
        }
    }
}
