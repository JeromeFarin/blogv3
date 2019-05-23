<?php
namespace Application\Controller\Manage;

use Framework\Controller;
use Application\Handler\CommentHandler;
use Application\Manager\CommentManager;
use Zend\Diactoros\ServerRequest;
use Framework\FlashBag;

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
     * @var FlashBag
     */
    private $flash;

    /**
     * Constructor
     *
     * @param CommentHandler $handler
     * @param CommentManager $manager
     */
    public function __construct(CommentHandler $handler, CommentManager $manager, FlashBag $flash) {
        $this->handler = $handler;
        $this->manager = $manager;
        $this->flash = $flash;
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
     * Comment like or report
     *
     * @param ServerRequest $request
     * @return redirect
     */
    public function commentLikeReport(ServerRequest $request)
    {
        preg_match('/(\w+)(\/)(\d)$/i', $request->getUri()->getPath(), $matches);

        if ($matches[1] === 'like') {
            $this->manager->like($matches[3]);
            $this->flash->setFlash(['Comment liked']);
        }

        if ($matches[1] === 'report') {
            $this->manager->report($matches[3]);
            $this->flash->setFlash(['Comment reported']);
        }

        return $this->redirect('/chapter/'.$request->getParsedBody()['comment']['chapter']);
    }
}
