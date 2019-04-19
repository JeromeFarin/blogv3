<?php

namespace Application\Form\Book;

use Application\Model\Book;
use Framework\FormInterface;
use Framework\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Required;

/**
 * Class AddForm
 * @package Application\Form\Book
 */
class AddForm extends Required implements FormInterface
{
    /**
     * @var Book
     */
    private $book;

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
    public function __construct(ModelInterface $model)
    {
        $this->book = $model;
    }

    public function handle(ServerRequestInterface $request): FormInterface
    {
        if ($request->getMethod() === "POST" && isset($request->getParsedBody()["book"])) {
            $this->submitted = true;

            $bookData = $request->getParsedBody()["book"];
            
            $this->book->setName($bookData["name"]);
            $this->book->setOwner($bookData["owner"]);

            if (isset($bookData["finished_date"])) {
                $this->book->setFinished_date($bookData["finished_date"]);
            }

            $file_name = $_FILES['book']['name'];
            $file_size =$_FILES['book']['size'];
            $file_tmp =$_FILES['book']['tmp_name'];
            $file_type=$_FILES['book']['type'];
            $file_ext=strtolower(end(explode('.',$_FILES['book']['name'])));
            dd($file_ext);
            // move_uploaded_file($file_tmp,"images/".$file_name);
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
        if ($this->book->getName() === null || empty($this->book->getName())) {
            $this->errors["name"] = "Le nom ne doit pas être vide.";
        } else {
            $required = $this->required($this->book,'name');
            if ($required != "") {
                $this->errors["name"] = $required;
            }
        }

        if ($this->book->getOwner() === null || empty($this->book->getOwner())) {
            $this->errors["owner"] = "Le nom de l'auteur ne doit pas être vide.";
        } else {
            $required = $this->required($this->book,'owner');
            if ($required != "") {
                $this->errors["owner"] = $required;
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
        return $this->book;
    }
}
