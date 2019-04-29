<?php

namespace Application\Form\Chapter;

use Application\Model\Chapter;
use Framework\FormInterface;
use Framework\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Required;

/**
 * Class AddForm
 * @package Application\Form\Chapter
 */
class AddForm extends Required implements FormInterface
{
    /**
     * @var Chapter
     */
    private $chapter;

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
    public function __construct(\Application\Model\Chapter $model)
    {
        $this->chapter = $model;
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
            $this->chapter->setnumber($chapterData["number"]); 
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
        if ($this->chapter->getNumber() === null || empty($this->chapter->getNumber())) {
            $this->errors["number"] = "Le numéro ne doit pas être vide.";
        } else {
            $required = $this->required($this->chapter,'number');
            if ($required != "") {
                $this->errors["number"] = $required;
            }
        }

        if ($this->chapter->getName() === null || empty($this->chapter->getName())) {
            $this->errors["name"] = "Le nom ne doit pas être vide.";
        } else {
            $required = $this->required($this->chapter,'name');
            if ($required != "") {
                $this->errors["name"] = $required;
            }
        }

        return count($this->errors) === 0;
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
