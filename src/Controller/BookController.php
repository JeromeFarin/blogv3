<?php
namespace Application\Controller;

use Framework\Controller;
use Application\Model;

class BookController extends Controller
{
    public function list()
    {
        $bookManager = $this->getManager(Model\Book::class);
        $result = $bookManager->findAll();
        return $this->render('book/book_list.twig', array(
            'title' => 'Book List',
            'books' => $result
        ));
    }

    public function book($id)
    {
        $bookManager = $this->getManager(Model\Book::class);
        $book = new Model\Book();
        $book->setId($id);
        $result = $bookManager->find($book);
        return $this->render('book/book.twig', array(
            'book' => $result,
            'title' => 'Book'
        ));
    }

    public function delete($request)
    {
        $book = new Model\Book();
        $book->setId($request->getParsedBody()['id']);
        $bookManager = $this->getManager(Model\Book::class);
        $bookManager->delete($book);
        return $this->redirect('/blogv3/book/');
    }

    public function persist($request)
    {
        $book = new Model\Book();
        if (isset($request->getParsedBody()["id"])) {
            $book->setId($request->getParsedBody()["id"]);
        }
        $book->setName($request->getParsedBody()["name"]);
        $book->setOwner($request->getParsedBody()["owner"]);
        if (isset($request->getParsedBody()["cover"])) {
            $book->setCover($request->getParsedBody()["cover"]);
        }
        if (isset($request->getParsedBody()["date_finish"])) {
            $book->setDate($request->getParsedBody()["date_finish"]);
        }
        
        $bookManager = $this->getManager(Model\Book::class);
        $back = $bookManager->persist($book);
        return $this->redirect('/blogv3/book/'.$back);
    }
}
