<?php
namespace Application\Manager;

use Framework\Manager;
use Application\Model\Comment;

class CommentManager extends Manager
{
    public $model;

    public function __construct(Comment $model) {
        $this->model = $model;
    }

    public function findAllCommentAll()
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select * from %s order by report desc",
                $this->model::getInfo()["table"]
            )
        );

        if ($statement->execute()) {
            return $statement->fetchAll(\PDO::FETCH_CLASS);
        } else {
            throw new \Exception("Error findAll()");
        }
    }

    public function findAllComment($param)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select * from %s where chapter = %s",
                $this->model::getInfo()["table"],
                $param
            )
        );

        if ($statement->execute()) {
            return $statement->fetchAll(\PDO::FETCH_CLASS);
        } else {
            throw new \Exception("Error findAll()");
        }
    }

    public function like($object)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "update %s set likes = likes + 1 where id = %s",
                $this->model::getInfo()["table"],
                $object->id
            )
        );

        if ($statement->execute()) {
            return true;
        } else {
            throw new \Exception("Error like()");
        }
    }

    public function report($object)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "update %s set report = report + 1 where id = %s",
                $this->model::getInfo()["table"],
                $object->id
            )
        );

        if ($statement->execute()) {
            return true;
        } else {
            throw new \Exception("Error report()");
        }
    }
}