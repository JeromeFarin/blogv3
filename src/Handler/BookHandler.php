<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\BookManager;

class BookHandler extends Controller
{
    private $manager;

    public function __construct(BookManager $manager) {
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

    public function listDone()
    {
        return $this->manager->findAllDone();
    }

    public function edit($book)
    {        
        return $this->manager->update($book);
    }

    public function one($id)
    {
        return $this->manager->find($id);
    }
}
