<?php

namespace Application\Controller;

use Framework\Controller;
use Framework\Container;

/**
 * Class BookController
 * @package Application\Controller
 */
class BookController extends Controller
{
    private $container;

    public function __construct($container) {
        $this->container = $this->container->get('BookController');
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
