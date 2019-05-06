<?php
namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Form\CommentForm;
use Application\Handler\CommentHandler;
use Application\Manager\CommentManager;

class CommentController extends Controller
{
    private $form;
    private $handler;
    private $manager;

    public function __construct(CommentForm $form, CommentHandler $handler, CommentManager $manager) {
        $this->form = $form;
        $this->handler = $handler;
        $this->manager = $manager;
    }

    public function comment($request)
    {        
        $this->form->handle($request);
        
        if ($this->form->isSubmitted()) {
            if (isset($request->getParsedBody()['delete'])) {
                $this->manager->delete($this->form->getData());
                return $this->redirect('/blogv3/admin/comment/');
            }
            
            if ($this->form->isValid()) {
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
