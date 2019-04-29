<?php

namespace Application\Controller;

use Framework\Controller;

/**
 * Class BookController
 * @package Application\Controller
 */
class BookController extends Controller
{
    private $book_handler;
    private $model;
    private $chapter_handler;

    public function __construct(\Application\Handler\BookHandler $book_handler,\Application\Model\Book $model,\Application\Handler\ChapterHandler $chapter_handler) {
        $this->book_handler = $book_handler;
        $this->model = $model;
        $this->chapter_handler = $chapter_handler;
    }
    
    public function list()
    {
        return $this->render('book/book_list.twig', array(
            'title' => 'Book List',
            'books' => $this->book_handler->list()
        ));
    }

    public function book($id)
    {
        return $this->render('book/book.twig', array(
            'title' => 'Book',
            'book' => $this->book_handler->one($id,$this->model),
            'chapters' => $this->chapter_handler->listOne($id)
        ));
    }
}
