<?php

namespace Application\Controller;

use Application\Model\Book;
use Application\Handler\BookHandler;
use Framework\Controller;
use Application\Form\Book\AddForm;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BookController
 * @package Application\Controller
 */
class BookController extends Controller
{
    /**
     * @var Book
     */
    private $model;

    /**
     * @var BookHandler
     */
    private $handler;

    public function __construct() {
        $this->model = new Book();
        $this->handler = new BookHandler;
    }

    public function list(ServerRequestInterface $request)
    {
        $book = new Book();

        $form = new AddForm($book);

        $form->handle($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form);
        }



        return $this->render('book/book_list.twig', array(
            'title' => 'Book List',
            'books' => $this->handler->list(),
            "form" => $form
        ));
    }

    public function book($id)
    {
        $result = $this->handler->one($id,$this->model);
        $arrayResult = (array)$result;
        $request = array(
            'id' => $arrayResult['id'],
            'name' => $arrayResult['name'],
            'owner' => $arrayResult['owner']
        );
        $submit = array(
            'Edit book',
            'Delete book'
        );
        $form = (new AddForm())->create('post',$request,$submit);
        return $this->render('book/book.twig', array(
            'book' => $result,
            'title' => 'Book',
            'form' => $form
        ));
    }

    public function delete($request)
    {
        $this->handler->delete($request,$this->model);
        return $this->redirect('/blogv3/book/');
    }

    public function persist($request)
    {
        if (isset($request->getParsedBody()["id"])) {
            $result = $this->handler->edit($request,$this->model);
        } else {
            $result = $this->handler->add($request,$this->model);
        }
        return $this->redirect('/blogv3/book/'.$result);
    }
}
