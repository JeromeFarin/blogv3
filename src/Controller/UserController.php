<?php
namespace Application\Controller;

use Application\Model\User;
use Application\Handler\UserHandler;
use Framework\Controller;

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
        $result = $this->handler->login($request,$this->model);
        if ($result == 'profile') {
            return $this->render('user/login.twig', array(
                'title' => 'Connection',
                'error' => 'No profiles found'
            ));
        }
        if ($result == 'pass') {
            return $this->render('user/login.twig', array(
                'title' => 'Connection',
                'error' => 'Wrong password'
            ));
        }
        if ($result == 'ok') {
            return $this->redirect('/blogv3');
        }
        return $this->render('user/login.twig', array(
            'title' => 'Connection'
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
