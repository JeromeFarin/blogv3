<?php

namespace Application\Form;

use Application\Model\Book;
use Framework\FormInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\UploadedFile;

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
    protected $submitted = false;

    /**
     * @var array
     */
    protected $errors = [];

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
     * Upload file for book cover
     *
     * @return mixed
     */
    private function uploadFile()
    {
        $file = new UploadedFile($_FILES['book_cover']['tmp_name'],$_FILES['book_cover']['size'],$_FILES['book_cover']['error'],$_FILES['book_cover']['name']);

        $extension = strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
            
        $cover = $this->model->getId().'.'.$extension;

        dd($cover);

        move_uploaded_file($_FILES["book_cover"]["tmp_name"], __DIR__."/../../public/img/cover/$cover");

        return $cover;
    }
}
