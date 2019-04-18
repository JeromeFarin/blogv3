<?php
namespace Application\Handler;

use Application\Model\Book;
use Framework\Controller;

class BookHandler extends Controller
{
    public function add($book)
    {
        $bookManager = $this->getManager(Book::class);
        return $bookManager->insert($book);
    }

    public function delete($model)
    {
        $bookManager = $this->getManager(Book::class);
        return $bookManager->delete($model);
    }

    public function list()
    {
        $bookManager = $this->getManager(Book::class);
        return $bookManager->findAll();
    }

    public function edit($book)
    {        
        $bookManager = $this->getManager(Book::class);
        return $bookManager->update($book);
    }

    public function one($id,$model)
    {
        $bookManager = $this->getManager(Book::class);
        $model->setId($id);
        return $bookManager->find($model);
    }
}
