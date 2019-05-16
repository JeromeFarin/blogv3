<?php
namespace Application\Controller;

use Framework\Controller;
use Application\Model\User;
use Application\Handler\UserHandler;
use Application\Form\UserForm;

class UserController extends Controller
{
    private $handler;
    private $form;
    private $model;

    public function __construct(UserHandler $handler, UserForm $form, User $model) {
        $this->handler = $handler;
        $this->form = $form;
        $this->model = $model;
    }
    public function login($request)
    {
        if ($request === null) {
            $this->model->setMail($_SESSION['mail']);
            $this->model->setPass($_SESSION['pass']);

            $this->handler->login($this->model);

            return $this->redirect('/');
        }
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->handler->login($this->form);
            if (empty($this->form->errors)) {
                return $this->redirect('/');
            }
        }
        
        return $this->render('user/login.twig', array(
            'title' => 'Connection',
            'form' => $this->form
        ));
    }

    public function logout($request)
    {
        $result = $this->handler->logout();
        if ($result) {
            return $this->redirect('/');
        }
    }
}
