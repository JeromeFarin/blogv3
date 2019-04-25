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
        $this->container = $container;
    }
    
    public function list()
    {
        $handler = $this->container->get('Application\Handler\BookHandler');

        return $this->render('book/book_list.twig', array(
            'title' => 'Book List',
            'books' => $handler->list()
        ));
    }

    public function book($id)
    {
        $model = $this->container->get('Application\Model\Book');

        $handler = $this->container->get('Application\Handler\BookHandler');

        return $this->render('book/book.twig', array(
            'title' => 'Book',
            'book' => $handler->one($id,$model)
        ));
    }
}
