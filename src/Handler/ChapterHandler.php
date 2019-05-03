<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\ChapterManager;
use Application\Model\Chapter;

class ChapterHandler extends Controller
{
    private $manager;
    private $model;

    public function __construct(ChapterManager $manager, Chapter $model) {
        $this->manager = $manager;
        $this->model = $model;
    }

    public function add($chapter)
    {
        return $this->manager->insert($chapter);
    }

    public function delete($model)
    {
        return $this->manager->delete($model);
    }

    public function list()
    {
        return $this->manager->findAll();
    }

    public function listOne($id)
    {
        return $this->manager->findAllChapter($id);
    }

    public function edit($chapter)
    {        
        return $this->manager->update($chapter);
    }

    public function one($id)
    {
        $this->model->setId($id);
        return $this->manager->find($this->model);
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
        foreach ($list as $value) {
            if ($value->number < $pos) {
                return $value;
            }
        }
    }
}
