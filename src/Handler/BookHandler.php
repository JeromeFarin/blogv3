<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\BookManager;
use Zend\Diactoros\ServerRequest;
use Application\Form\BookForm;
use Framework\FlashBag;

class BookHandler extends Controller
{
    private $manager;
    private $form;
    private $flash;

    public function __construct(BookManager $manager, BookForm $form, FlashBag $flash) {
        $this->manager = $manager;
        $this->form = $form;
        $this->flash = $flash;
    }

    public function one($id)
    {
        return $this->manager->find($id);
    }

    public function list()
    {
        return $this->manager->findAll();
    }

    public function listDone()
    {
        return $this->manager->findAllDone();
    }

    public function add(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->flash->setFlash(array('done' => 'Book was created'));
            return $this->manager->insert($this->form->getData());
        }

        return $this->flash->setFlash($this->form->getErrors());
        
    }

    public function edit(ServerRequest $request)
    {        
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->flash->setFlash(array('done' => 'Book was modified'));
            return $this->manager->update($this->form->getData());
        }
        
        return $this->flash->setFlash($this->form->getErrors());
    }

    public function delete(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted()) {
            $this->flash->setFlash(array('done' => 'Book was deleted'));
            return $this->manager->delete($this->form->getData());
        }
        
        return $this->flash->setFlash($this->form->getErrors());
    }
}
