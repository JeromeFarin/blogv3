<?php
namespace Application\Manager;

use Framework\Manager;
use Application\Model\Chapter;

class ChapterManager extends Manager
{
    public $model;

    public function __construct() {
        $this->model = new Chapter();
    }

    public function findAllChapter($id)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select * from %s where book = %s and content not like 'null'",
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

    public function chapterNumber($book)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select max(number) as number from %s where book = %s",
                $this->model::getInfo()["table"],
                $book
            )
        );

        if ($statement->execute()) {
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Error findAll(chapter)");
        }
    }
}