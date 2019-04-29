<?php
namespace Application\Handler;

use Framework\Controller;

class BookHandler extends Controller
{
    private $manager;

    public function __construct(\Application\Manager\BookManager $manager) {
        $this->manager = $manager;
    }

    public function add($book)
    {
        return $this->manager->insert($book);
    }

    public function delete($model)
    {
        return $this->manager->delete($model);
    }

    public function list()
    {
        return $this->manager->findAll();
    }

    public function edit($book)
    {        
        return $this->manager->update($book);
    }

    public function one($id,$model)
    {
        $model->setId($id);
        return $this->manager->find($model);
    }
}
