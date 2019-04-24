<?php
namespace Application\Controller;

use Framework\Controller;
use Application\Handler\BookHandler;
use Application\Form\Book\AddForm;
use Application\Model\Book;

class AdminController extends Controller
{
    public function panel()
    {   
        return $this->render('admin.twig', array(
            'title' => 'Panel Admin'
        ));
    }

    public function book($request)
    {   
        $book = new Book();

        $form = new AddForm($book);

        $handler = new BookHandler();
        
        $form->handle($request);

        if ($form->isSubmitted()) {
            if (isset($request->getParsedBody()['delete'])) {
                $handler->delete($book);
                return $this->redirect('/blogv3/admin/book/');
            }

            if ($form->isValid()) {
                if (isset($request->getParsedBody()['edit'])) {
                    $handler->edit($form->getData());
                    return $this->redirect('/blogv3/admin/book/');
                }

                $handler->add($form->getData());
                return $this->redirect('/blogv3/admin/book/');
            }
        }
        // dd($handler->list());
        return $this->render('admin/book.twig', array(
            'title' => 'Manage Books',
            'books' => $handler->list(),
            'form' => $form
        ));
    }
}
