<?php
namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Handler\BookHandler;
use Zend\Diactoros\ServerRequest;

class BookController extends Controller
{
    private $handler;

    public function __construct(BookHandler $handler) {
        $this->handler = $handler;
    }

    public function book()
    {    
        return $this->render('admin/book.twig', array(
            'title' => 'Manage Books',
            'books' => $this->handler->list(),
            'chapters' => $this->handler->listDone()
        ));
    }

    public function create(ServerRequest $request)
    {
        $this->handler->add($request);
        return $this->redirect('/admin/book/');
    }

    public function edit(ServerRequest $request)
    {
        $this->handler->edit($request);
        return $this->redirect('/admin/book/');
    }

    public function delete(ServerRequest $request)
    {
        $this->handler->delete($request);
        return $this->redirect('/admin/book/');
    }
}
