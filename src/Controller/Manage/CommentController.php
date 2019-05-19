<?php
namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Handler\CommentHandler;
use Application\Manager\CommentManager;
use Zend\Diactoros\ServerRequest;

/**
 * Class CommentController
 * @package Application\Controller\Manage
 */
class CommentController extends Controller
{
    /**
     * Handler
     *
     * @var CommentHandler
     */
    private $handler;

    /**
     * Manager
     *
     * @var CommentManager
     */
    private $manager;

    /**
     * Constructor
     *
     * @param CommentHandler $handler
     * @param CommentManager $manager
     */
    public function __construct(CommentHandler $handler, CommentManager $manager) {
        $this->handler = $handler;
        $this->manager = $manager;
    }

    /**
     * CommentList with chapter
     *
     * @return render
     */
    public function comment()
    {     
        return $this->render('admin/comment.twig', array(
            'title' => 'Manage Comments',
            'comments' => $this->handler->listAll()
        ));
    }

    /**
     * Comment created
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function commentCreate(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);

        $this->handler->add($request);
        return $this->redirect('/chapter/'.$matches[0]);
    }

    /**
     * Comment deleted
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function commentRemove(ServerRequest $request)
    {
        $this->handler->delete($request);
        return $this->redirect('/admin/comment/');
    }

    /**
     * Comment liked
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function commentLike(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);

        $this->manager->like($matches[0]);
        return $this->redirect('/chapter/'.$request->getParsedBody()['comment']['chapter']);
    }

    /**
     * Comment reported
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function commentReport(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);

        $this->manager->report($matches[0]);
        return $this->redirect('/chapter/'.$request->getParsedBody()['comment']['chapter']);
    }
}
