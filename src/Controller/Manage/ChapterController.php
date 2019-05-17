<?php
namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Handler\ChapterHandler;
use Application\Handler\BookHandler;
use Zend\Diactoros\ServerRequest;

class ChapterController extends Controller
{
    private $chapter_handler;
    private $book_handler;

    public function __construct(BookHandler $book_handler, ChapterHandler $chapter_handler) {
        $this->chapter_handler = $chapter_handler;
        $this->book_handler = $book_handler;
    }

    public function chapter()
    {
        return $this->render('admin/chapter.twig', array(
            'title' => 'Manage Chapters',
            'books' => $this->book_handler->list(),
            'chapters' => $this->chapter_handler->list()
        ));
    }

    public function create(ServerRequest $request)
    {
        $this->chapter_handler->add($request);
        return $this->redirect('/admin/chapter/');
    }

    public function edit(ServerRequest $request)
    {
        $this->chapter_handler->edit($request);
        return $this->redirect('/admin/chapter/');
    }

    public function delete(ServerRequest $request)
    {
        $this->chapter_handler->delete($request);
        return $this->redirect('/admin/chapter/');
    }

    public function content(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);

        return $this->render('admin/content.twig', array(
            'title' => 'Edit Chapter Content',
            'chapter' => $this->chapter_handler->one($matches[0])
        ));
    }

    public function contentUpdate(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);

        $this->chapter_handler->content($request);
        return $this->redirect('/chapter/'.$matches[0]);
    }
}
