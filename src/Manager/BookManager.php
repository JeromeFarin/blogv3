<?php
namespace Application\Manager;

use Framework\Manager;
use Application\Model\Book;

class BookManager extends Manager
{
    public $model;
    public $namespace;

    public function __construct() {
        $this->model = new Book();
        $this->namespace = 'Application\Model\Book';
    }
}