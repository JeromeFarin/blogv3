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

            if (isset($_FILES['book_cover'])) {
                $this->uploadFile();
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
        // $file_size =$_FILES['book_cover']['size'];
        // $file_tmp =$_FILES['book_cover']['tmp_name'];
        // $file_type=substr($_FILES['book_cover']['type'],strpos($_FILES['book_cover']['type'],'/')+1);
        
        // $file = basename("../public/img/cover/.".$file_type);
        // dd(dir("../public/img/cover"));
        // dd($file_tmp,"/img/cover");

        // if ($file_size <= 5000000) {
        //     if (move_uploaded_file($file_tmp,"../public/img/cover/")) {
        //         echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        //     } else {
        //         echo "Sorry, there was an error uploading your file.";
        //     }
        // }

        $target_dir = "../public/img/cover";
        $target_file = $target_dir . basename($_FILES["book_cover"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["book_cover"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["book_cover"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["book_cover"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["book_cover"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}
