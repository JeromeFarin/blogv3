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

    public function like($param)
    {
        # code...
    }
}