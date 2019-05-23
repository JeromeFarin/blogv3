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
        foreach ($this->manager->findAllChapter($model->book) as $value) {
            if ($value->number > $model->number) {
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
        foreach (array_reverse($this->manager->findAllChapter($model->book)) as $value) {
            if ($value->number < $model->number) {
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
