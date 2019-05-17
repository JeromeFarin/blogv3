<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\CommentManager;
use Zend\Diactoros\ServerRequest;
use Application\Form\CommentForm;

class CommentHandler extends Controller
{
    private $manager;
    private $form;

    public function __construct(CommentManager $manager, CommentForm $form) {
        $this->manager = $manager;
        $this->form = $form;
    }

    public function add(ServerRequest $request)
    {
        $this->form->handle($request);
        
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return $this->manager->insert($this->form->getData());
        }

        return $this->form;
    }

    public function delete(ServerRequest $request)
    {
        $this->form->handle($request);
        
        if ($this->form->isSubmitted()) {
            return $this->manager->delete($this->form->getData());
        }

        return $this->form;
    }

    public function list($param)
    {
        return $this->manager->findAllComment($param);
    }

    public function listAll()
    {
        return $this->manager->findAllCommentAll();
    }
}
