<?php
namespace Application\Controller;

use Application\Model\Book;
use Application\Handler\BookHandler;
use Framework\Controller;
use Application\Form\Book\AddForm;

class BookController extends Controller
{
    private $model;
    private $handler;

    public function __construct() {
        $this->model = new Book();
        $this->handler = new BookHandler;
    }
    public function list()
    {
        $result = $this->handler->list();
        $inputs = array(
            'name' => '',
            'owner' => ''
        );
        $submit = array(
            'Create new book'
        );
        $form = (new AddForm())->create('post',$inputs,$submit);
        return $this->render('book/book_list.twig', array(
            'title' => 'Book List',
            'books' => $result,
            'form' => $form
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
