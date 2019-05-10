<?php

namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Form\UserForm;
use Application\Handler\UserHandler;
use Zend\Diactoros\ServerRequest;

class UserController extends Controller
{
    private $form;
    private $handler;

    public function __construct(UserForm $form, UserHandler $handler) {
        $this->form = $form;
        $this->handler = $handler;
    }
    public function user(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted()) {
            if (isset($request->getParsedBody()['delete'])) {
                $this->handler->delete($this->form->getData());
                return $this->redirect('/blogv3/admin/user/');
            }

            if ($this->form->isValid()) {
                if (isset($request->getParsedBody()['edit'])) {
                    $this->handler->edit($this->form->getData());
                    return $this->redirect('/blogv3/admin/user/');
                }

                if (isset($request->getParsedBody()['reset'])) {
                    $this->handler->sendResetPass($this->form->getData());
                    return $this->redirect('/blogv3/admin/user/');
                }

                $this->handler->add($this->form->getData());
                return $this->redirect('/blogv3/admin/user/');
            }
        }
        
        return $this->render('admin/user.twig', array(
            'title' => 'Manage Users',
            'users' => $this->handler->list(),
            'form' => $this->form
        ));
    }
}
