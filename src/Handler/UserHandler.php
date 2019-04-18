<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Model\User;

class UserHandler extends Controller
{
    private $model;

    public function login($model,$request)
    {
        $this->model = $model;

        if ($request == null) {
            $model->setMail($_SESSION['mail']);
            $model->setPass($_SESSION['pass']);

            return $this->check($model);
        }   
    }

    public function check($model)
    {
        $userManager = $this->getManager(User::class);
        $check = $userManager->check($model);
        if ($check === false) {
            return 'mail';
        } else {
            if (password_verify($model->getPass(),$check['pass'])) {
                $_SESSION['mail'] = $check['mail'];
                $_SESSION['pass'] = $model->getPass();
                return true;
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
