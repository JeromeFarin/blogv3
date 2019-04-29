<?php

namespace Application\Controller;

use Framework\Controller;

/**
 * Class BookController
 * @package Application\Controller
 */
class ChapterController extends Controller
{
    private $model;
    private $chapter_handler;

    public function __construct(\Application\Model\Chapter $model,\Application\Handler\ChapterHandler $chapter_handler) {
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
