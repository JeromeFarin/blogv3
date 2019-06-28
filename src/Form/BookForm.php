<?php

namespace Application\Form;

use Application\Model\Book;
use Framework\FormInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\UploadedFile;
use Psr\Http\Message\UploadedFileInterface;

/**
 * Class AddForm
 * @package Application\Form
 */
class BookForm extends Form implements FormInterface
{
    /**
     * @var Book
     */
    public $model;

    /**
     * @var bool
     */
    public $submitted = false;

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
            
            if (isset($request->getUploadedFiles()['book_cover']) && $request->getUploadedFiles()['book_cover']->getSize() > 0) {
                $this->model->setCover($this->uploadFile($request->getUploadedFiles()['book_cover']));
            } else {
                $this->model->setCover('default.png');
            }

            if (isset($request->getParsedBody()["book"]["hidden"])) {
                $this->model->setHidden(1);
            }
        }

        return $this;
    }

    /**
     * Upload file for book cover
     *
     * @return mixed
     */
    private function uploadFile(UploadedFileInterface $uploadedFile)
    {
        $extension = strtolower(pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION));
            
        $cover = $this->model->getId().'.'.$extension;

        $uploadedFile->moveTo(__DIR__."/../../public/img/cover/$cover");

        return $cover;
    }
}
