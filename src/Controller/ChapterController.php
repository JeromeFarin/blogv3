<?php

namespace Application\Controller;

use Framework\Controller;
use Application\Model\Chapter;
use Application\Handler\ChapterHandler;

/**
 * Class BookController
 * @package Application\Controller
 */
class ChapterController extends Controller
{
    private $model;
    private $chapter_handler;

    public function __construct(Chapter $model, ChapterHandler $chapter_handler) {
        $this->model = $model;
        $this->chapter_handler = $chapter_handler;
    }

    public function chapter($id)
    {
        // dd($this->chapter_handler->next($this->chapter_handler->one($id,$this->model)));
        return $this->render('chapter/chapter.twig', array(
            'title' => 'Chapter',
            'chapter' => $this->chapter_handler->one($id,$this->model),
            'next' => $this->chapter_handler->next($this->chapter_handler->one($id,$this->model)),
            'previous' => $this->chapter_handler->previous($this->chapter_handler->one($id,$this->model))
        ));
    }
}
