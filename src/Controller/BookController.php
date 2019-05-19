<?php

namespace Application\Controller;

use Framework\Controller;
use Application\Handler\BookHandler;
use Application\Handler\ChapterHandler;
use Zend\Diactoros\ServerRequest;

/**
 * Class BookController
 * @package Application\Controller
 */
class BookController extends Controller
{
    private $book_handler;
    private $chapter_handler;

    /**
     * Constructor
     *
     * @param BookHandler $book_handler
     * @param ChapterHandler $chapter_handler
     */
    public function __construct(BookHandler $book_handler, ChapterHandler $chapter_handler) {
        $this->book_handler = $book_handler;
        $this->chapter_handler = $chapter_handler;
    }
    
    /**
     * List of books
     *
     * @return render
     */
    public function list()
    {
        return $this->render('book/book_list.twig', array(
            'title' => 'Book List',
            'books' => $this->book_handler->listDone()
        ));
    }

    /**
     * Book
     *
     * @param ServerRequest $request
     * @return render
     */
    public function book(ServerRequest $request)
    {
        return $this->render('book/book.twig', array(
            'title' => 'Book',
            'book' => $this->book_handler->one($request),
            'chapters' => $this->chapter_handler->listOne($request)
        ));
    }
}
