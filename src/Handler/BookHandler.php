<?php
namespace Application\Handler;

use Application\Model\Book;
use Framework\Controller;

class BookHandler extends Controller
{
    private $model;

    public function __construct() {
        $this->model = new Book();
    }

    public function add($request)
    {
        $this->model->setName($request->getParsedBody()["name"]);
        $this->model->setOwner($request->getParsedBody()["owner"]);
        
        $bookManager = $this->getManager(Book::class);
        return $bookManager->insert($this->model);
    }

    public function delete($request)
    {
        $this->model->setId($request->getParsedBody()['id']);
        $bookManager = $this->getManager(Book::class);
        return $bookManager->delete($this->model);
    }

    public function list()
    {
        $bookManager = $this->getManager(Book::class);
        return $bookManager->findAll();
    }

    public function edit($request)
    {
        $this->model->setId($request->getParsedBody()["id"]);
        $this->model->setName($request->getParsedBody()["name"]);
        $this->model->setOwner($request->getParsedBody()["owner"]);
        
        $bookManager = $this->getManager(Book::class);
        return $bookManager->update($this->model);
    }

    public function one($id)
    {
        $bookManager = $this->getManager(Book::class);
        $this->model->setId($id);
        return $bookManager->find($this->model);
    }
}
