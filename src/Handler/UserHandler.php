<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Model\User;

class UserHandler extends Controller
{
    public function login($request,$model)
    {
        if ($request != null) {
            $model->setMail($request->getParsedBody()['mail']);
            $model->setPass($request->getParsedBody()['pass']);

            return $this->check($model);
        } else {
            if (isset($_SESSION['mail']) && isset($_SESSION['pass'])) {
                $model->setMail($_SESSION['mail']);
                $model->setPass($_SESSION['pass']);

                return $this->check($model);
            } else {
                return 'login';
            }
        }   
    }

    public function check($model)
    {
        $userManager = $this->getManager(User::class);
        $check = $userManager->check($model);
        if ($check === false) {
            return 'profile';
        } else {
            if (password_verify($model->getPass(),$check['pass'])) {
                $_SESSION['mail'] = $check['mail'];
                $_SESSION['pass'] = $model->getPass();

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
