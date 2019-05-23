<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\BookManager;
use Zend\Diactoros\ServerRequest;
use Application\Form\BookForm;
use Framework\FlashBag;

/**
 * Class BookHandler
 * @package Application\Handler
 */
class BookHandler extends Controller
{
    /**
     * @var BookManager
     */
    protected $manager;

    /**
     * @var BookForm
     */
    protected $form;

    /**
     * @var FlashBag
     */
    protected $flash;

    /**
     * Constructor 
     *
     * @param BookManager $manager
     * @param BookForm $form
     * @param FlashBag $flash
     */
    public function __construct(BookManager $manager, BookForm $form, FlashBag $flash) {
        $this->manager = $manager;
        $this->form = $form;
        $this->flash = $flash;
    }

    /**
     * @param ServerRequest $request
     * @return mixed
     */
    public function one(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);
        
        return $this->manager->find($matches[0]);
    }

    /**
     * @return mixed
     */
    public function list()
    {
        return $this->manager->findAll();
    }

    /**
     * @return mixed
     */
    public function listDone()
    {
        return $this->manager->findAllDone();
    }
}
