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
            // dd($bookData);
            if (isset($bookData["id"])) {
                $this->book->setId($bookData["id"]);
            }

            $this->book->setName($bookData["name"]);
            $this->book->setOwner($bookData["owner"]);

            if (isset($bookData["finished_date"])) {
                $this->book->setFinished_date($bookData["finished_date"]);
            }

            if (isset($_FILES['book_cover']) && $_FILES['book_cover']['size'] > 0) {
                $this->uploadFile();
            } elseif (isset($bookData["cover"])) {
                $this->book->setCover($bookData["cover"]);
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

    private function uploadFile()
    {
        if ($_FILES['book_cover']['size'] < 5000000) {
            $extension = strtolower(pathinfo($_FILES['book_cover']['name'], PATHINFO_EXTENSION));
            
            $cover = $this->book->getId().'.'.$extension;

            move_uploaded_file($_FILES["book_cover"]["tmp_name"], __DIR__."/../../../public/img/cover/$cover");

            return $this->book->setCover($cover);
        }
        $this->errors["cover"] = "Le fichier ne doit pas dépasser 5Mo.";
    }
}
