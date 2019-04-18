<?php
namespace Application\Controller;

use Application\Model\User;
use Application\Handler\UserHandler;
use Framework\Controller;
use Application\Form\User\AddForm;

class UserController extends Controller
{
    protected $model;
    protected $handler;

    public function __construct() {
        $this->model = new User();
        $this->handler = new UserHandler();
    }
    public function login($request)
    {
        if (isset($_SESSION['mail']) && isset($_SESSION['pass'])) {

            $this->model->setMail($_SESSION['mail']);
            $this->model->setPass($_SESSION['pass']);

            return $this->handler->login($this->model,$request);
        }
        
        $form = new AddForm($this->model);

        $form->handle($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handler->login($form->getData(),$request);
            return $this->redirect('/blogv3');
        }

        return $this->render('user/login.twig', array(
            'title' => 'Connection',
            'form' => $form
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
