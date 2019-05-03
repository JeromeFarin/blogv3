<?php

namespace Application\Controller;

use Framework\Controller;
use Application\Model\Chapter;
use Application\Handler\ChapterHandler;
use Application\Handler\CommentHandler;
use Application\Form\CommentForm;

/**
 * Class BookController
 * @package Application\Controller
 */
class ChapterController extends Controller
{
    private $model;
    private $chapterHandler;
    private $commentHandler;
    private $form;

    public function __construct(Chapter $model, ChapterHandler $chapterHandler, CommentHandler $commentHandler, CommentForm $form) {
        $this->model = $model;
        $this->chapterHandler = $chapterHandler;
        $this->commentHandler = $commentHandler;
        $this->form = $form;
    }

    public function chapter($request)
    {
        $param = substr($request->getUri()->getPath(),strrpos($request->getUri()->getPath(),'/')+1);
        
        // dd($request);

        $this->form->handle($request);
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->commentHandler->add($this->form->getData());
            return $this->redirect('/blogv3/chapter/'.$this->form->getData()->chapter);
        }

        return $this->render('chapter/chapter.twig', array(
            'title' => 'Chapter',
            'chapter' => $this->chapterHandler->one($param,$this->model),
            'next' => $this->chapterHandler->next($this->chapterHandler->one($param,$this->model)),
            'previous' => $this->chapterHandler->previous($this->chapterHandler->one($param,$this->model)),
            'comments' => $this->commentHandler->list($param),
            'form' => $this->form
        ));
    }
}