<?php
namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Form\CommentForm;
use Application\Handler\CommentHandler;
use Application\Manager\CommentManager;
use Zend\Diactoros\ServerRequest;

class CommentController extends Controller
{
    private $form;
    private $handler;
    private $manager;

    public function __construct(CommentForm $form, CommentHandler $handler, CommentManager $manager) {
        $this->form = $form;
        $this->handler = $handler;
        $this->manager = $manager;
    }

    public function comment()
    {     
        return $this->render('admin/comment.twig', array(
            'title' => 'Manage Comments',
            'comments' => $this->handler->listAll(),
            'form' => $this->form
        ));
    }

    public function commentCreate(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);

        $this->handler->add($request);
        return $this->redirect('/chapter/'.$matches[0]);
    }

    public function commentRemove(ServerRequest $request)
    {
        $this->handler->delete($request);
        return $this->redirect('/admin/comment/');
    }

    public function commentLike(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);

        $this->manager->like($matches[0]);
        return $this->redirect('/chapter/'.$request->getParsedBody()['comment']['chapter']);
    }

    public function commentReport(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);

        $this->manager->report($matches[0]);
        return $this->redirect('/chapter/'.$request->getParsedBody()['comment']['chapter']);
    }
}
