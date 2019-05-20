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
class ChapterForm implements FormInterface
{
    /**
     * @var Chapter
     */
    private $chapter;

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
        $this->chapter = $model;
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

            foreach ($chapterData as $property => $value) {
                $this->chapter->{sprintf("set%s", ucfirst($property))}($value);
            }

            if (!isset($chapterData["number"])) {
                $this->chapter->setnumber($this->manager->chapterNumber($chapterData["book"]));
            }

            $content = $this->manager->checkChapter($this->chapter->getId());

            if (!empty($content)) {
                $this->chapter->setContent($content[0]['content']);
            }
        }

        return $this;
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
        $valid = new Validator($this->chapter);
        
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
        return $this->chapter;
    }
}
