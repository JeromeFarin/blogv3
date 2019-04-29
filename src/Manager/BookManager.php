<?php
namespace Application\Manager;

use Framework\Manager;

class BookManager extends Manager
{
    public $model;

    public function __construct(\Application\Model\Book $model) {
        $this->model = $model;
    }
}