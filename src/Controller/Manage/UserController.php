<?php

namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Form\UserForm;
use Application\Handler\UserHandler;
use Zend\Diactoros\ServerRequest;

class UserController extends Controller
{
    private $handler;

    public function __construct(UserHandler $handler) {
        $this->handler = $handler;
    }

    public function user()
    {
        return $this->render('admin/user.twig', array(
            'title' => 'Manage Users',
            'users' => $this->handler->list()
        ));
    }

    public function add(ServerRequest $request)
    {
        $this->handler->add($request);
        return $this->redirect('/admin/user');
    }

    public function edit(ServerRequest $request)
    {
        $this->handler->edit($request);
        return $this->redirect('/admin/user');
    }

    public function remove(ServerRequest $request)
    {
        $this->handler->delete($request);
        return $this->redirect('/admin/user');
    }

    public function reset(ServerRequest $request)
    {
        $this->handler->reset($request);
        return $this->redirect('/admin/user');
    }

    public function pass(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);
        
        return $this->render('admin/password.twig', array(
            'title' => 'Change Password',
            'id' => $matches[0]
        ));
    }

    public function passChange(ServerRequest $request)
    {
        $this->handler->passUpdate($request);
        return $this->redirect('/');
    }
}
