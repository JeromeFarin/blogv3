<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\ChapterManager;

class ChapterHandler extends Controller
{
    private $manager;

    public function __construct(ChapterManager $manager) {
        $this->manager = $manager;
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

    public function one($id,$model)
    {
        $model->setId($id);
        return $this->manager->find($model);
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
