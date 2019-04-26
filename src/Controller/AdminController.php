<?php
namespace Application\Controller;

use Framework\Controller;

class AdminController extends Controller
{
    private $model;
    private $form;
    private $handler;

    public function __construct(\Application\Model\Book $model,\Application\Form\Book\AddForm $form,\Application\Handler\BookHandler $handler) {
        $this->model = $model;
        $this->form = $form;
        $this->handler = $handler;
    }

    public function panel()
    {   
        return $this->render('admin.twig', array(
            'title' => 'Panel Admin'
        ));
    }

    public function book($request)
    {        
        $this->form->handle($request);

        if ($this->form->isSubmitted()) {
            if (isset($request->getParsedBody()['delete'])) {
                $this->handler->delete($this->form->getData());
                return $this->redirect('/blogv3/admin/book/');
            }

            if ($this->form->isValid()) {
                if (isset($request->getParsedBody()['edit'])) {
                    $this->handler->edit($this->form->getData());
                    return $this->redirect('/blogv3/admin/book/');
                }

                $this->handler->add($this->form->getData());
                return $this->redirect('/blogv3/admin/book/');
            }
        }
        
        return $this->render('admin/book.twig', array(
            'title' => 'Manage Books',
            'books' => $this->handler->list(),
            'form' => $this->form
        ));
    }
}
