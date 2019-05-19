<?php

namespace Application\Controller;

use Framework\Controller;
use Application\Handler\ChapterHandler;
use Application\Handler\CommentHandler;
use Application\Form\CommentForm;
use Application\Manager\CommentManager;
use Zend\Diactoros\ServerRequest;

/**
 * Class ChapterController
 * @package Application\Controller
 */
class ChapterController extends Controller
{
    /**
     * Chapter Handler
     *
     * @var ChapterHandler
     */
    private $chapterHandler;

    /**
     * Comment Handler
     *
     * @var CommentHandler
     */
    private $commentHandler;

    /**
     * Constructor
     *
     * @param ChapterHandler $chapterHandler
     * @param CommentHandler $commentHandler
     */
    public function __construct(ChapterHandler $chapterHandler, CommentHandler $commentHandler) {
        $this->chapterHandler = $chapterHandler;
        $this->commentHandler = $commentHandler;
    }

    /**
     * Chapter
     *
     * @param ServerRequest $request
     * @return render
     */
    public function chapter(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);

        $chapter = $this->chapterHandler->one($matches[0]);

        return $this->render('chapter/chapter.twig', array(
            'title' => 'Chapter',
            'chapter' => $chapter,
            'next' => $this->chapterHandler->next($chapter),
            'previous' => $this->chapterHandler->previous($chapter),
            'comments' => $this->commentHandler->list($matches[0])
        ));
    }
}