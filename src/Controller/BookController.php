<?php
namespace Application\Controller;

use Framework\Controller;
use Application\Manager;
use Application\Model;

class BookController extends Controller
{
    public function list()
    {
        $bookManager = new Manager\BookManager();
        $result = $bookManager->findAll()->fetchAll(\PDO::FETCH_CLASS,'Application\Model\Book');
        return $this->render('Book/BookList.php',$result);
    }

    public function book($id)
    {
        $bookManager = new Manager\BookManager();
        $book = new Model\Book();
        $book->setId($id);
        $result = $bookManager->find($book)->fetchAll(\PDO::FETCH_CLASS,'Application\Model\Book');
        return $this->render('Book/Book.php',$result);
    }

    public function delete($request)
    {
        $book = new Model\Book();
        $book->setId($request->getParsedBody()['id']);
        $bookManager = new Manager\BookManager();
        $bookManager->delete($book);
        return $this->redirect('/blogv3/book/');
    }

    public function persist($values)
    {
        $book = new Model\Book();
        if (isset($values->getParsedBody()["id"])) {
            $book->setId($values->getParsedBody()["id"]);
        }
        $book->setName($values->getParsedBody()["name"]);
        $book->setOwner($values->getParsedBody()["owner"]);
        if (isset($values->getParsedBody()["cover"])) {
            $book->setCover($values->getParsedBody()["cover"]);
        }
        if (isset($values->getParsedBody()["date_finish"])) {
            $book->setDate($values->getParsedBody()["date_finish"]);
        }
        
        $bookManager = new Manager\BookManager();
        $back = $bookManager->persist($book);
        return $this->redirect('/blogv3/book/'.$back);
    }
}
