<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\ChapterManager;
use Zend\Diactoros\ServerRequest;
use Application\Form\ChapterForm;
use Framework\FlashBag;

/**
 * Class ChapterHandler
 * @package Application\Handler
 */
class ChapterHandler extends Controller
{
    /**
     * @var ChapterManager
     */
    private $manager;

    /**
     * @var ChapterForm
     */
    private $form;

    /**
     * @var FlashBag
     */
    private $flash;

    /**
     * Constructor
     *
     * @param ChapterManager $manager
     * @param ChapterForm $form
     * @param FlashBag $flash
     */
    public function __construct(ChapterManager $manager, ChapterForm $form, FlashBag $flash) {
        $this->manager = $manager;
        $this->form = $form;
        $this->flash = $flash;
    }

    /**
     * Create Chapter
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function add(ServerRequest $request)
    {
        $this->form->handle($request);
        
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->flash->setFlash(array('done' => 'Chapter was created'));
            return $this->manager->insert($this->form->getData());
        }

        return $this->flash->setFlash($this->form->getErrors());
    }

    /**
     * Modified Chapter
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function edit(ServerRequest $request)
    {        
        $this->form->handle($request);
        
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->flash->setFlash(array('done' => 'Chapter was modified'));
            return $this->manager->update($this->form->getData());
        }

        return $this->flash->setFlash($this->form->getErrors());
    }

    /**
     * Delete Chapter
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function delete(ServerRequest $request)
    {
        $this->form->handle($request);
        
        if ($this->form->isSubmitted()) {
            $this->flash->setFlash(array('done' => 'Chapter was deleted'));
            return $this->manager->delete($this->form->getData());
        }

        return $this->flash->setFlash($this->form->getErrors());
    }

    /**
     * Find all chapter
     *
     * @return mixed
     */
    public function list()
    {
        return $this->manager->findAll();
    }

    /**
     * Find all chapter not empty
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function listOne(ServerRequest $request)
    {
        preg_match('/(\d+)/i', $request->getUri()->getPath(), $matches);

        return $this->manager->findAllChapter($matches[0]);
    }

    /**
     * Find chapter with id
     *
     * @param int $id
     * @return void
     */
    public function one($id)
    {
        return $this->manager->find($id);
    }

    /**
     * Find if next chapter exist
     *
     * @param Chapter $model
     * @return mixed
     */
    public function next($model)
    {
        $pos = $model->number;
        $list = $this->manager->findAllChapter($model->book);
        foreach ($list as $value) {
            if ($value->number > $pos) {
                return $value;
            }
        }
    }

    /**
     * Find if previous chapter exist
     *
     * @param Chapter $model
     * @return mixed
     */
    public function previous($model)
    {
        $pos = $model->number;
        $list = $this->manager->findAllChapter($model->book);
        foreach (array_reverse($list) as $value) {
            if ($value->number < $pos) {
                return $value;
            }
        }
    }

    /**
     * Chapter content
     *
     * @param ServerRequest $request
     * @return mixed
     */
    public function content(ServerRequest $request)
    {
        $this->form->handle($request);
        
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return $this->manager->update($this->form->getData());
        }
    }
}
