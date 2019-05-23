<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\CommentManager;
use Zend\Diactoros\ServerRequest;
use Application\Form\CommentForm;
use Framework\FlashBag;

/**
 * Class CommentHandler
 */
class CommentHandler extends Controller
{
    /**
     * @var CommentManager
     */
    private $manager;

    /**
     * @var CommentForm
     */
    private $form;

    /**
     * @var FlashBag
     */
    private $flash;

    /**
     * Constructor
     *
     * @param CommentManager $manager
     * @param CommentForm $form
     * @param FlashBag $flash
     */
    public function __construct(CommentManager $manager, CommentForm $form, FlashBag $flash) {
        $this->manager = $manager;
        $this->form = $form;
        $this->flash = $flash;
    }

    /**
     * Comment list with chapter id
     *
     * @param int $param
     * @return mixed
     */
    public function list($param)
    {
        return $this->manager->findAllComment($param);
    }

    /**
     * List all comment
     *
     * @return mixed
     */
    public function listAll()
    {
        return $this->manager->findAllCommentAll();
    }
}
