<?php
namespace Application\Controller\Manage;

use Framework\Controller;

class BookController extends Controller
{
    private $form;
    private $handler;

    public function __construct(\Application\Form\BookForm $form, \Application\Handler\BookHandler $handler) {
        $this->form = $form;
        $this->handler = $handler;
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
        // dd($this->form);
        
        return $this->render('admin/book.twig', array(
            'title' => 'Manage Books',
            'books' => $this->handler->list(),
            'form' => $this->form
        ));
    }
}
