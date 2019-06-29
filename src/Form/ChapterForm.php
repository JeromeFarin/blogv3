<?php

namespace Application\Form;

use Application\Model\Chapter;
use Framework\FormInterface;
use Framework\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;
use Application\Manager\ChapterManager;

/**
 * Class AddForm
 * @package Application\Form\Chapter
 */
class ChapterForm extends Form implements FormInterface
{
    /**
     * @var Chapter
     */
    protected $model;

    /** 
     * @var ChapterManager
     */
    protected $manager;

    /**
     * @var bool
     */
    protected $submitted = false;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * AddForm constructor.
     * @param ModelInterface $model
     */
    public function __construct(Chapter $model, ChapterManager $manager)
    {
        $this->model = $model;
        $this->manager = $manager;
    }

    /**
     * @param ServerRequestInterface $request
     * @return FormInterface
     */
    public function handle(ServerRequestInterface $request): FormInterface
    {
        if ($request->getMethod() === "POST" && isset($request->getParsedBody()["chapter"])) {
            $this->submitted = true;

            $chapterData = $request->getParsedBody()["chapter"];

            $this->getSetter($chapterData);

            if (!isset($chapterData["number"])) {
                $this->model->setnumber($this->manager->chapterNumber($chapterData["book"]));
            } else {
                $this->notNew($chapterData);
            }
        }

        return $this;
    }

    /**
     * If chapter not created
     *
     * @param array $data
     * @return void
     */
    private function notNew(array $data)
    {
        $content = $this->manager->checkChapter($this->model->getId());
    
        if (!empty($content)) {
            if (!empty($data['content'])) {
                $this->model->setContent($data['content']);
            } else {
                $this->model->setContent($content[0]['content']);
            }
        }
    }
}
