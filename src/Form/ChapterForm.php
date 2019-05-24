<?php

namespace Application\Form;

use Application\Model\Chapter;
use Framework\FormInterface;
use Framework\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Validator;
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
    private $manager;

    /**
     * @var bool
     */
    private $submitted = false;

    /**
     * @var array
     */
    private $errors = [];

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

    /**
     * @return boolean
     */
    public function isSubmitted(): bool
    {
        return $this->submitted;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        $valid = new Validator($this->model);
        
        if (!empty($valid->valid())) {
            $this->errors = $valid->valid();
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return ModelInterface
     */
    public function getData(): ModelInterface
    {
        return $this->model;
    }
}
