<?php
namespace Application\Handler;

use Application\Model\Book;
use Framework\Controller;

class BookHandler extends Controller
{
    public function add($request,$model)
    {
        $model->setName($request->getParsedBody()["name"]);
        $model->setOwner($request->getParsedBody()["owner"]);
        
        $bookManager = $this->getManager(Book::class);
        return $bookManager->insert($model);
    }

    public function delete($request,$model)
    {
        $model->setId($request->getParsedBody()['id']);
        $bookManager = $this->getManager(Book::class);
        return $bookManager->delete($model);
    }

    public function list()
    {
        $bookManager = $this->getManager(Book::class);
        return $bookManager->findAll();
    }

    public function edit($request,$model)
    {
        $model->setId($request->getParsedBody()["id"]);
        $model->setName($request->getParsedBody()["name"]);
        $model->setOwner($request->getParsedBody()["owner"]);
        
        $bookManager = $this->getManager(Book::class);
        return $bookManager->update($model);
    }

    public function one($id,$model)
    {
        $bookManager = $this->getManager(Book::class);
        $model->setId($id);
        return $bookManager->find($model);
    }
}
