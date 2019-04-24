<?php

namespace Application\Controller;

use Application\Model\Book;
use Framework\Controller;

/**
 * Class BookController
 * @package Application\Controller
 */
class BookController extends Controller
{
    public function list()
    {
        return $this->render('book/book_list.twig', array(
            'title' => 'Book List',
            'books' => $this->handler->list()
        ));
    }

    public function book($id)
    {
        $model = new Book();

        return $this->render('book/book.twig', array(
            'title' => 'Book',
            'book' => $this->handler->one($id,$model)
        ));
    }
}
