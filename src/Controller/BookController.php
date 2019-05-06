<?php

namespace Application\Controller;

use Framework\Controller;
use Application\Handler\BookHandler;
use Application\Handler\ChapterHandler;

/**
 * Class BookController
 * @package Application\Controller
 */
class BookController extends Controller
{
    private $book_handler;
    private $chapter_handler;

    public function __construct(BookHandler $book_handler, ChapterHandler $chapter_handler) {
        $this->book_handler = $book_handler;
        $this->chapter_handler = $chapter_handler;
    }
    
    public function list()
    {
        return $this->render('book/book_list.twig', array(
            'title' => 'Book List',
            'books' => $this->book_handler->listDone()
        ));
    }

    public function book($request)
    {
        $param = substr($request->getUri()->getPath(),strrpos($request->getUri()->getPath(),'/')+1);

        return $this->render('book/book.twig', array(
            'title' => 'Book',
            'book' => $this->book_handler->one($param),
            'chapters' => $this->chapter_handler->listOne($param)
        ));
    }
}
