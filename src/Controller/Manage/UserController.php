<?php

namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Handler\UserHandler;
use Zend\Diactoros\ServerRequest;

/**
 * Class UserController
 * @package Application\Controller\Manage
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
     * User list
     *
     * @return render
     */
    public function user()
    {
        return $this->render('admin/user.twig', array(
            'title' => 'Manage Users',
            'users' => $this->handler->list()
        ));
    }

    /**
     * User create or modifie
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function persist(ServerRequest $request)
    {
        $this->handler->persist($request);
        return $this->redirect('/admin/user/');
    }

    /**
     * User deleted
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function remove(ServerRequest $request)
    {
        $this->handler->delete($request);
        return $this->redirect('/admin/user');
    }

    /**
     * Send mail for password
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function reset(ServerRequest $request)
    {
        $this->handler->reset($request);
        return $this->redirect('/admin/user');
    }

    /**
     * Page for change password
     *
     * @param ServerRequest $request
     * @return render
     */
    public function pass(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);
        
        return $this->render('admin/password.twig', array(
            'title' => 'Change Password',
            'id' => $matches[0]
        ));
    }

    /**
     * Password changed
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function passChange(ServerRequest $request)
    {
        $this->handler->passUpdate($request);
        return $this->redirect('/');
    }
}
