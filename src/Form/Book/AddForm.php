<?php
namespace Application\Form\Book;

use Application\Model\Book;

class AddForm
{
    private $model;

    public function __construct() {
        $this->model = new Book();
    }

    public function create($type,$request,$submit)
    {
        $form = "<form method='$type'>";
        $types = $this->model::getInfo()['type'];
        $holder = $this->model::getInfo()['placeholder'];
        $required = $this->model::getInfo()['required'];

        foreach ($request as $key => $value) {
            if (isset($types[$key])) {
                if (isset($holder[$key])) {
                    if (isset($required[$key])) {
                        $form .= "<input type='$types[$key]' name='$key' placeholder='$holder[$key]' value='$value' required>";
                    } else {
                        $form .= "<input type='$types[$key]' name='$key' placeholder='$holder[$key]' value='$value'>";
                    }
                } else {
                    if (isset($required[$key])) {
                        $form .= "<input type='$types[$key]' name='$key' value='$value' required>";
                    } else {
                        $form .= "<input type='$types[$key]' name='$key' value='$value'>";
                    }
                }
            }
        }

        foreach ($submit as $value) {
            if (strpos($value,'delete')) {
                $form .= "<input type='submit' name='delete'  onclick='return confirm('Are you sure to delete this book ?');' value='$value'>";
            }
            $form .= "<input type='submit' value='$value'>";
        }

        $form .= "</form>";

        return $form;
    }
}
