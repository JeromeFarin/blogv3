<?php
namespace Application\Controller;

use Framework\Controller;
use Application\Manager;
use Application\Model;

class BookController extends Controller
{
    public function list()
    {
        $bookManager = $this->getManager(Model\Book::class);
        $result = $bookManager->findAll()->fetchAll(\PDO::FETCH_CLASS,'Application\Model\Book');
        return $this->render('Book/BookList.php',$result);
    }

    public function book($id)
    {
        $bookManager = $this->getManager(Model\Book::class);
        $book = new Model\Book();
        $book->setId($id);
        $result = $bookManager->find($book)->fetchAll(\PDO::FETCH_CLASS,'Application\Model\Book');
        return $this->render('Book/Book.php',$result);
    }

    public function delete($request)
    {
        $book = new Model\Book();
        $book->setId($request->getParsedBody()['id']);
        $bookManager = $this->getManager(Model\Book::class);
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
        
        $bookManager = $this->getManager(Model\Book::class);
        $back = $bookManager->persist($book);
        return $this->redirect('/blogv3/book/'.$back);
    }
}
