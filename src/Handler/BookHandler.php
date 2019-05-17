<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\BookManager;
use Zend\Diactoros\ServerRequest;
use Application\Form\BookForm;

class BookHandler extends Controller
{
    private $manager;
    private $form;

    public function __construct(BookManager $manager, BookForm $form) {
        $this->manager = $manager;
        $this->form = $form;
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
            return $this->manager->insert($this->form->getData());
        }
        
        return $this->form;
        
    }

    public function edit(ServerRequest $request)
    {        
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return $this->manager->update($this->form->getData());
        }
        
        return $this->form;
    }

    public function delete(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted()) {
            return $this->manager->delete($this->form->getData());
        }
        
        return $this->form;
    }
}
