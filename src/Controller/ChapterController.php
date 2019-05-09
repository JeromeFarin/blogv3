<?php

namespace Application\Controller;

use Framework\Controller;
use Application\Handler\ChapterHandler;
use Application\Handler\CommentHandler;
use Application\Form\CommentForm;
use Application\Manager\CommentManager;
use Zend\Diactoros\ServerRequest;

/**
 * Class BookController
 * @package Application\Controller
 */
class ChapterController extends Controller
{
    private $chapterHandler;
    private $commentHandler;
    private $form;
    private $manager;

    public function __construct(ChapterHandler $chapterHandler, CommentHandler $commentHandler, CommentForm $form, CommentManager $manager) {
        $this->chapterHandler = $chapterHandler;
        $this->commentHandler = $commentHandler;
        $this->form = $form;
        $this->manager = $manager;
    }

    public function chapter(ServerRequest $request,string $param)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->getData()->like !== null) {
            $this->manager->like($this->form->getData());
            return $this->redirect('/blogv3/chapter/'.$this->form->getData()->chapter);
        }

        if ($this->form->isSubmitted() && $this->form->getData()->report !== null) {
            $this->manager->report($this->form->getData());
            return $this->redirect('/blogv3/chapter/'.$this->form->getData()->chapter);
        }

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->commentHandler->add($this->form->getData());
            return $this->redirect('/blogv3/chapter/'.$this->form->getData()->chapter);
        }

        $chapter = $this->chapterHandler->one($param);

        return $this->render('chapter/chapter.twig', array(
            'title' => 'Chapter',
            'chapter' => $chapter,
            'next' => $this->chapterHandler->next($chapter),
            'previous' => $this->chapterHandler->previous($chapter),
            'comments' => $this->commentHandler->list($param),
            'form' => $this->form
        ));
    }
}