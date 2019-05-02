<?php
namespace Application\Manager;

use Framework\Manager;
use Application\Model\Book;

class BookManager extends Manager
{
    public $model;

    public function __construct(Book $model) {
        $this->model = $model;
    }
}