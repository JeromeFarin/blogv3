<?php
namespace Application\Controller;

use Framework\Controller;
use Application\Model\User;

class SecurityController extends Controller
{
    public function check()
    {
        $user = new User();
        $user->setUser($_SESSION['user']);
        $user->setPass($_SESSION['pass']);
        $securityManager = $this->getManager(Model\User::class);
        $result = $securityManager->security($user,$pass)->fetchAll(\PDO::FETCH_CLASS,'Application\Model\User');
        // return $this->render('Book/BookList.php',$result);
    }
}
