<?php
namespace Application\Controller;

use Framework\Controller;
use Application\Model\User;
use Application\Handler\UserHandler;
use Zend\Diactoros\ServerRequest;

/**
 * Class UserController
 * @package Application\Controller
 */
class UserController extends Controller
{
    /**
     * Handler
     *
     * @var UserHandler
     */
    private $handler;

    /**
     * Constructor
     *
     * @param UserHandler $handler
     */
    public function __construct(UserHandler $handler) {
        $this->handler = $handler;
    }

    /**
     * Login page
     *
     * @return render
     */
    public function login()
    {
        return $this->render('user/login.twig', array(
            'title' => 'Connect to admin panel'
        ));
    }

    /**
     * Auto login with SESSION
     *
     * @return redirect
     */
    public function loginAuto()
    {
        $user = new User();
        $user->setMail($_SESSION['mail']);
        $user->setPass($_SESSION['pass']);
        
        return $this->handler->checkMail($user);
    }

    /**
     * Login has been sent
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function loginSend(ServerRequest $request)
    {
        $login = $this->handler->login($request);

        if ($login) {
            return $this->redirect('/');
        } else {
            return $this->redirect('/login');
        }
    }

    /**
     * Logout
     *
     * @return redirect
     */
    public function logout()
    {
        $this->handler->logout();
        return $this->redirect('/');
    }
}
