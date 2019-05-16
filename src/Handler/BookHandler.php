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

    public function add(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->manager->insert($this->form->getData());
            return $this->redirect('/admin/book/');
        }
        // dd($this->form);
        return $this->form;
        
    }

    public function delete($book)
    {
        return $this->manager->delete($book);
    }

    public function list()
    {
        return $this->manager->findAll();
    }

    public function listDone()
    {
        return $this->manager->findAllDone();
    }

    public function edit($book)
    {        
        return $this->manager->update($book);
    }

    public function one($id)
    {
        return $this->manager->find($id);
    }
}
