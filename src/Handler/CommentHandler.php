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
     * Create Comment
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function add(ServerRequest $request)
    {
        $this->form->handle($request);
        
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->flash->setFlash(['Comment was created']);
            return $this->manager->insert($this->form->getData());
        }

        return $this->flash->setFlash($this->form->getErrors());
    }

    /**
     * Delete Comment
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function delete(ServerRequest $request)
    {
        $this->form->handle($request);
        
        if ($this->form->isSubmitted()) {
            $this->flash->setFlash(['Comment was deleted']);
            return $this->manager->delete($this->form->getData());
        }

        return $this->flash->setFlash($this->form->getErrors());
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
