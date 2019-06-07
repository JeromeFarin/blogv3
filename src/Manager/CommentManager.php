<?php
namespace Application\Manager;

use Framework\Manager;
use Application\Model\Comment;

/**
 * Class CommentManager
 * @package Application\Manager
 */
class CommentManager extends Manager
{
    /**
     * @var Comment
     */
    public $model;

    public function __construct() {
        $this->model = new Comment();
    }

    /**
     * Find all comment order by report 
     *
     * @return mixed
     */
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

    /**
     * Get all comment with chapter id
     *
     * @param integer $param
     * @return mixed
     */
    public function findAllComment(int $param)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select * from %s where chapter = %s order by id desc",
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

    /**
     * Set a like
     *
     * @param int $param
     * @return void
     */
    public function like(int $param)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "update %s set likes = likes + 1 where id = %s",
                $this->model::getInfo()["table"],
                $param
            )
        );

        if ($statement->execute()) {
            return true;
        } else {
            throw new \Exception("Error like()");
        }
    }

    /**
     * Set a report
     *
     * @param integer $param
     * @return mixed
     */
    public function report(int $param)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "update %s set report = report + 1 where id = %s",
                $this->model::getInfo()["table"],
                $param
            )
        );

        if ($statement->execute()) {
            return true;
        } else {
            throw new \Exception("Error report()");
        }
    }
}