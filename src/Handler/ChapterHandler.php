<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\ChapterManager;
use Zend\Diactoros\ServerRequest;
use Application\Form\ChapterForm;

class ChapterHandler extends Controller
{
    private $manager;
    private $form;

    public function __construct(ChapterManager $manager, ChapterForm $form) {
        $this->manager = $manager;
        $this->form = $form;
    }

    public function add(ServerRequest $request)
    {
        $this->form->handle($request);
        
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return $this->manager->insert($this->form->getData());
        }

        return $this->form;
    }

    public function edit(ServerRequest $request)
    {        
        $this->form->handle($request);
        
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return $this->manager->update($this->form->getData());
        }

        return $this->form;
    }

    public function delete(ServerRequest $request)
    {
        $this->form->handle($request);
        
        if ($this->form->isSubmitted()) {
            return $this->manager->delete($this->form->getData());
        }

        return $this->form;
    }

    public function list()
    {
        return $this->manager->findAll();
    }

    public function listOne($id)
    {
        return $this->manager->findAllChapter($id);
    }

    public function one($id)
    {
        return $this->manager->find($id);
    }

    public function next($model)
    {
        $pos = $model->number;
        $list = $this->manager->findAllChapter($model->book);
        foreach ($list as $value) {
            if ($value->number > $pos) {
                return $value;
            }
        }
    }

    public function previous($model)
    {
        $pos = $model->number;
        $list = $this->manager->findAllChapter($model->book);
        foreach (array_reverse($list) as $value) {
            if ($value->number < $pos) {
                return $value;
            }
        }
    }

    public function content(ServerRequest $request)
    {
        $this->form->handle($request);
        
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return $this->manager->update($this->form->getData());
        }
    }
}
