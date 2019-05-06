<?php

namespace Application\Form;

use Application\Model\Chapter;
use Framework\FormInterface;
use Framework\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Validator;
use Application\Handler\ChapterHandler;

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

    private $handler;

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
    public function __construct(Chapter $model, ChapterHandler $handler)
    {
        $this->chapter = $model;
        $this->handler = $handler;
    }

    public function handle(ServerRequestInterface $request): FormInterface
    {
        if ($request->getMethod() === "POST" && isset($request->getParsedBody()["chapter"])) {
            $this->submitted = true;

            $chapterData = $request->getParsedBody()["chapter"];
            // dd($chapterData);
            if (isset($chapterData["id"])) {
                $this->chapter->setId($chapterData["id"]);
            }

            $this->chapter->setBook($chapterData["book"]);
            $this->chapter->setName($chapterData["name"]);

            if (isset($chapterData["number"])) {
                $this->chapter->setnumber($chapterData["number"]); 
            } else {
                $this->chapter->setnumber($this->handler->findChapterNumber($chapterData["book"]));
            }
            
            if (isset($chapterData["content"])) {
                $this->chapter->setContent($chapterData["content"]);
            }
        }

        return $this;
    }

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
