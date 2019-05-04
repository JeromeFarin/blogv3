<?php
namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Form\CommentForm;
use Application\Handler\CommentHandler;

class CommentController extends Controller
{
    private $form;
    private $handler;

    public function __construct(CommentForm $form, CommentHandler $handler) {
        $this->form = $form;
        $this->handler = $handler;
    }

    public function comment($request)
    {        
        $this->form->handle($request);

        if ($this->form->isSubmitted()) {
            if (isset($request->getParsedBody()['delete'])) {
                $this->handler->delete($this->form->getData());
                return $this->redirect('/blogv3/admin/comment/');
            }
            
            if ($this->form->isValid()) {
                if (isset($request->getParsedBody()['edit'])) {
                    $this->handler->edit($this->form->getData());
                    return $this->redirect('/blogv3/admin/comment/');
                }

                $this->handler->add($this->form->getData());
                return $this->redirect('/blogv3/admin/comment/');
            }
        }
        
        return $this->render('admin/comment.twig', array(
            'title' => 'Manage Comments',
            'comments' => $this->handler->listAll(),
            'form' => $this->form
        ));
    }
}
