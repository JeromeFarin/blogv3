<?php
namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Handler\BookHandler;
use Zend\Diactoros\ServerRequest;

/**
 * Class BookController
 * @package Application\Controller\Manage
 */
class BookController extends Controller
{
    /**
     * BookHandler
     *
     * @var BookHandler
     */
    private $handler;

    /**
     * Constructor
     *
     * @param BookHandler $handler
     */
    public function __construct(BookHandler $handler) {
        $this->handler = $handler;
    }

    /**
     * Book list
     *
     * @return render
     */
    public function book()
    {    
        return $this->render('admin/book.twig', array(
            'title' => 'Manage Books',
            'books' => $this->handler->list(),
            'chapters' => $this->handler->listDone()
        ));
    }

    /**
     * Book Created
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function create(ServerRequest $request)
    {
        $this->handler->createBook($request);
        return $this->redirect('/admin/book/');
    }

    /**
     * Book Modified
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function edit(ServerRequest $request)
    {
        $this->handler->edit($request);
        return $this->redirect('/admin/book/');
    }

    /**
     * Book Deleted
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function delete(ServerRequest $request)
    {
        $this->handler->delete($request);
        return $this->redirect('/admin/book/');
    }
}
