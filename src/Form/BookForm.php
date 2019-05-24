<?php

namespace Application\Form;

use Application\Model\Book;
use Framework\FormInterface;
use Framework\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Validator;

/**
 * Class AddForm
 * @package Application\Form
 */
class BookForm extends Form implements FormInterface
{
    /**
     * @var Book
     */
    protected $model;

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
     * @param Book $model
     */
    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    /**
     * Generate form
     *
     * @param ServerRequestInterface $request
     * @return FormInterface
     */
    public function handle(ServerRequestInterface $request): FormInterface
    {
        if ($request->getMethod() === "POST" && isset($request->getParsedBody()["book"])) {
            $this->submitted = true;

            $bookData = $request->getParsedBody()["book"];

            $this->getSetter($bookData);

            if (isset($_FILES['book_cover']) && $_FILES['book_cover']['size'] > 0) {
                $this->model->setCover($this->uploadFile());
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
     * @return boolean
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

    /**
     * Upload file for book cover
     *
     * @return mixed
     */
    private function uploadFile()
    {
        $extension = strtolower(pathinfo($_FILES['book_cover']['name'], PATHINFO_EXTENSION));
            
        $cover = $this->model->getId().'.'.$extension;

        move_uploaded_file($_FILES["book_cover"]["tmp_name"], __DIR__."/../../public/img/cover/$cover");

        return $cover;
    }
}
