<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Model\User;

class UserHandler extends Controller
{
    private $model;

    public function __construct() {
        $this->model = new User();
    }

    public function login($request)
    {
        if ($request != null) {
            $this->model->setMail($request->getParsedBody()['mail']);
            $this->model->setPass($request->getParsedBody()['pass']);

            return $this->check();
        } else {
            if (isset($_SESSION['mail']) && isset($_SESSION['pass'])) {
                $this->model->setMail($_SESSION['mail']);
                $this->model->setPass($_SESSION['pass']);

                return $this->check();
            } else {
                return 'login';
            }
        }   
    }

    public function check()
    {
        $userManager = $this->getManager(User::class);
        $check = $userManager->check($this->model);
        if ($check === false) {
            return 'profile';
        } else {
            if (password_verify($this->model->getPass(),$check['pass'])) {
                $_SESSION['mail'] = $check['mail'];
                $_SESSION['pass'] = $this->model->getPass();

                return 'ok';
            } else {
                return 'pass';
            }
        }
    }

    public function logout()
    {
        return session_destroy();
    }
}
