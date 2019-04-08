<?php
namespace Application\Controller;

use Framework\Controller;
use Application\Model;
use Framework;

class SecurityController extends Controller
{
    public function check($user,$pass)
    {
        $securityManager = $this->getManager(Model\User::class);
        $userG = $securityManager->security(new Model\User())->fetchAll(\PDO::FETCH_CLASS,'Application\Model\User');
        if ($user == $userG[0]->getUser()) {
            if ($pass == $userG[0]->getPass()) {
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;
                return true;
            } else {
                throw new \Exception("Bad Password");
            }
        } else {
            throw new \Exception("Bad User");             
        }
    }

    public function login($request)
    {
        $user = $request['user'];
        $pass = md5($request['pass']);

        $check = $this->check($user,$pass);

        if ($check) {
            return (new Framework\Controller())->redirect('/blogv3');
        }
    }

    public function logout()
    {
        session_destroy();
        return (new Framework\Controller())->redirect('/blogv3');
    }
}
