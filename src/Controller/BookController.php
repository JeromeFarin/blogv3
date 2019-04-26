<?php

namespace Application\Controller;

use Framework\Controller;

/**
 * Class BookController
 * @package Application\Controller
 */
class BookController extends Controller
{
    private $handler;
    private $model;

    public function __construct(\Application\Handler\BookHandler $handler,\Application\Model\Book $model) {
        $this->handler = $handler;
        $this->model = $model;
    }
    
    public function list()
    {
        return $this->render('book/book_list.twig', array(
            'title' => 'Book List',
            'books' => $this->handler->list()
        ));
    }

    public function book($id)
    {
        return $this->render('book/book.twig', array(
            'title' => 'Book',
            'book' => $this->handler->one($id,$this->model)
        ));
    }
}
