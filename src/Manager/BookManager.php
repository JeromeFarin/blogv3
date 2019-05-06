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

    public function findAllDone()
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select b.* from %s b inner join chapter c on c.book=b.id where c.content not like 'null' group by b.id",
                $this->model::getInfo()["table"]
            )
        );

        if ($statement->execute()) {
            return $statement->fetchAll(\PDO::FETCH_CLASS);
        } else {
            throw new \Exception("Error findAllDone()");
        }
    }
}