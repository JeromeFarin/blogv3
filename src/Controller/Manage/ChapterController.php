<?php

namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Form\ChapterForm;
use Application\Handler\ChapterHandler;
use Application\Handler\BookHandler;

class ChapterController extends Controller
{
    private $form;
    private $chapterHandler;
    private $bookHandler;

    public function __construct(ChapterForm $form, ChapterHandler $chapterHandler, BookHandler $bookHandler) {
        $this->form = $form;
        $this->chapterHandler = $chapterHandler;
        $this->bookHandler = $bookHandler;
    }

    public function chapter($request)
    {
        
        $this->form->handle($request);
        
        if ($this->form->isSubmitted()) {
            if (isset($request->getParsedBody()['delete'])) {
                $this->chapterHandler->delete($this->form->getData());
                return $this->redirect('/admin/chapter/');
            }

            if ($this->form->isValid()) {
                if (isset($request->getParsedBody()['edit'])) {
                    $this->chapterHandler->edit($this->form->getData());
                    return $this->redirect('/admin/chapter/');
                }

                $this->chapterHandler->add($this->form->getData());
                return $this->redirect('/admin/chapter/');
            }
        }

        return $this->render('admin/chapter.twig', array(
            'title' => 'Manage Chapters',
            'books' => $this->bookHandler->list(),
            'chapters' => $this->chapterHandler->list(),
            'form' => $this->form
        ));
    }



    public function content($request)
    {
        $param = substr($request->getUri()->getPath(),strrpos($request->getUri()->getPath(),'/')+1);
        
        $this->form->handle($request);
        
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->chapterHandler->edit($this->form->getData());
            return $this->redirect('/chapter/'.$param);
        }

        return $this->render('admin/content.twig', array(
            'title' => 'Edit Chapter Content',
            'chapter' => $this->chapterHandler->one($param)
        ));
    }
}
