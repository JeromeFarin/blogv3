<?php
namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Handler\ChapterHandler;
use Application\Handler\BookHandler;
use Zend\Diactoros\ServerRequest;

/**
 * Class ChapterController
 * @package Application\Controller\Manage
 */
class ChapterController extends Controller
{
    /**
     * ChapterHandler
     *
     * @var ChapterHandler
     */
    private $chapter_handler;

    /**
     * BookHandler
     *
     * @var BookHandler
     */
    private $book_handler;

    /**
     * Constructor
     *
     * @param BookHandler $book_handler
     * @param ChapterHandler $chapter_handler
     */
    public function __construct(BookHandler $book_handler, ChapterHandler $chapter_handler) {
        $this->chapter_handler = $chapter_handler;
        $this->book_handler = $book_handler;
    }

    /**
     * Chapter list
     *
     * @return render
     */
    public function chapter()
    {
        return $this->render('admin/chapter.twig', array(
            'title' => 'Manage Chapters',
            'books' => $this->book_handler->list(),
            'chapters' => $this->chapter_handler->list()
        ));
    }

    /**
     * Chapter created
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function create(ServerRequest $request)
    {
        $this->chapter_handler->add($request);
        return $this->redirect('/admin/chapter/');
    }

    /**
     * Chapter modified
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function edit(ServerRequest $request)
    {
        $this->chapter_handler->edit($request);
        return $this->redirect('/admin/chapter/');
    }

    /**
     * Chapter deleted
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function delete(ServerRequest $request)
    {
        $this->chapter_handler->delete($request);
        return $this->redirect('/admin/chapter/');
    }

    /**
     * Chapter content editor
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function content(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);

        return $this->render('admin/content.twig', array(
            'title' => 'Edit Chapter Content',
            'chapter' => $this->chapter_handler->one($matches[0])
        ));
    }

    /**
     * Chapter content updated
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function contentUpdate(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);

        $this->chapter_handler->content($request);
        return $this->redirect('/chapter/'.$matches[0]);
    }
}
