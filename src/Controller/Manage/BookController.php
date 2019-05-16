<?php
namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Form\BookForm;
use Application\Handler\BookHandler;

class BookController extends Controller
{
    private $form;
    private $handler;

    public function __construct(BookForm $form, BookHandler $handler) {
        $this->form = $form;
        $this->handler = $handler;
    }

    public function book($request)
    {        
        // $this->form->handle($request);

        // if ($this->form->isSubmitted()) {
        //     if (isset($request->getParsedBody()['delete'])) {
        //         $this->handler->delete($this->form->getData());
        //         return $this->redirect('/admin/book/');
        //     }
            
        //     if ($this->form->isValid()) {
        //         if (isset($request->getParsedBody()['edit'])) {
        //             $this->handler->edit($this->form->getData());
        //             return $this->redirect('/admin/book/');
        //         }

        //         $this->handler->add($this->form->getData());
        //         return $this->redirect('/admin/book/');
        //     }
        // }
        
        return $this->render('admin/book.twig', array(
            'title' => 'Manage Books',
            'books' => $this->handler->list(),
            'chapters' => $this->handler->listDone(),
            'form' => $this->form
        ));
    }

    public function create($request)
    {
        $this->handler->add($request);
        return $this->redirect('/admin/book/');
    }

    public function delete($request)
    {
        # code...
    }
}
