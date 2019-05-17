<?php
namespace Application\Controller;

use Framework\Controller;
use Application\Model\User;
use Application\Handler\UserHandler;
use Zend\Diactoros\ServerRequest;

class UserController extends Controller
{
    private $handler;

    public function __construct(UserHandler $handler) {
        $this->handler = $handler;
    }

    public function login()
    {
        return $this->render('user/login.twig', array(
            'title' => 'Connection'
        ));
    }

    public function loginAuto()
    {
        $user = new User();
        $user->setMail($_SESSION['mail']);
        $user->setPass($_SESSION['pass']);

        $this->handler->checkMail($user);

        return $this->redirect('/');
    }

    public function loginSend(ServerRequest $request)
    {
        $this->handler->login($request);
        return $this->redirect('/');
    }

    public function logout()
    {
        $this->handler->logout();
        return $this->redirect('/');
    }
}
