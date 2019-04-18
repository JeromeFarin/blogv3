<?php

namespace Application\Controller;

use Application\Model\Book;
use Application\Handler\BookHandler;
use Framework\Controller;
use Application\Form\Book\AddForm;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BookController
 * @package Application\Controller
 */
class BookController extends Controller
{
    /**
     * @var Book
     */
    private $model;

    /**
     * @var BookHandler
     */
    private $handler;

    public function __construct() {
        $this->model = new Book();
        $this->handler = new BookHandler;
    }

    public function list(ServerRequestInterface $request)
    {
        $form = new AddForm($this->model);

        $form->handle($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $this->handler->add($form->getData());
            return $this->redirect('/blogv3/book/'.$book);
        }

        return $this->render('book/book_list.twig', array(
            'title' => 'Book List',
            'books' => $this->handler->list(),
            'form' => $form
        ));
    }

    public function book($id,$request)
    {
        $result = $this->handler->one($id,$this->model);

        $form = new AddForm($this->model);
        
        $form->handle($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (isset($request->getParsedBody()['edit'])) {
                $id = $this->handler->edit($form->getData());
                return $this->redirect('/blogv3/book/'.$id);
            }
            if (isset($request->getParsedBody()['delete'])) {
                $this->handler->delete($this->model);
                return $this->redirect('/blogv3/book/');
            }
        }
        
        return $this->render('book/book.twig', array(
            'book' => $result,
            'title' => 'Book',
            'form' => $form
        ));
    }
}
