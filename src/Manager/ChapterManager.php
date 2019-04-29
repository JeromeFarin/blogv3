<?php
namespace Application\Manager;

use Framework\Manager;

class ChapterManager extends Manager
{
    public $model;

    public function __construct(\Application\Model\Chapter $model) {
        $this->model = $model;
    }

    public function findAllChapter($id)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select * from %s where book = %s",
                $this->model::getInfo()["table"],
                $id
            )
        );

        if ($statement->execute()) {
            return $statement->fetchAll(\PDO::FETCH_CLASS);
        } else {
            throw new \Exception("Error findAll(chapter)");
        }
    }
}