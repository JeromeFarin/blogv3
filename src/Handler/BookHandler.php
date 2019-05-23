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
<<<<<<< HEAD

    /**
     * @param ServerRequest $request
     * @return mixed
     */
    public function add(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->flash->setFlash(['Book was created']);
            return $this->manager->insert($this->form->getData());
        }

        return $this->flash->setFlash($this->form->getErrors());
        
    }

    /**
     * @param ServerRequest $request
     * @return mixed
     */
    public function edit(ServerRequest $request)
    {        
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->flash->setFlash(['Book was modified']);
            return $this->manager->update($this->form->getData());
        }
        
        return $this->flash->setFlash($this->form->getErrors());
    }

    /**
     * @param ServerRequest $request
     * @return mixed
     */
    public function delete(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted()) {
            $this->flash->setFlash(['Book was deleted']);
            return $this->manager->delete($this->form->getData());
        }
        
        return $this->flash->setFlash($this->form->getErrors());
    }
=======
>>>>>>> 27c5c0c27d3ec5ebc00dded83f0a41c6627b8737
}
