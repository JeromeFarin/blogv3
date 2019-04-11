<?php
namespace Application\Controller;

use Framework\Controller;
use Application\Model;
use Framework;

class UserController extends Controller
{
    public function login($request)
    {
        if ($request != null) {
            $userManager = $this->getManager(Model\User::class);
            $user = new Model\User();
            $user->setMail($request->getParsedBody()['mail']);
            $user->setPass($request->getParsedBody()['pass']);

            $check = $userManager->checkMail($user);
            if ($check === false) {
                return $this->render('user/login.twig', array(
                    'title' => 'Connection',
                    'error' => 'No profiles found'
                ));
            } else {
                if (password_verify($user->getPass(),$check['pass'])) {
                    $_SESSION['mail'] = $check['mail'];
                    $_SESSION['pass'] = $user->getPass();
                    return (new Framework\Controller())->redirect('/blogv3');
                } else {
                    return $this->render('user/login.twig', array(
                        'title' => 'Connection',
                        'error' => 'Wrong password'
                    ));
                }
            }
        } else {
            return $this->render('user/login.twig', array(
                'title' => 'Connection'
            ));
        }
    }

    public function logout()
    {
        session_destroy();
        return (new Framework\Controller())->redirect('/blogv3');
    }
}
