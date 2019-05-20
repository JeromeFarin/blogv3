<?php
namespace Application\Manager;

use Framework\Manager;
use Application\Model\Chapter;

/**
 * Class ChapterManager
 * @package Application\Manager
 */
class ChapterManager extends Manager
{
    /**
     * @var Chapter
     */
    public $model;

    /**
     * Constructor
     */
    public function __construct() {
        $this->model = new Chapter();
    }

    /**
     * Find all chapter with id book
     *
     * @param int $id
     * @return mixed
     */
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

    /**
     * Check if chapter content is null with id 
     *
     * @param int $id
     * @return mixed
     */
    public function checkChapter($id)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select * from %s where id = %s and content not like 'null'",
                $this->model::getInfo()["table"],
                $id
            )
        );

        if ($statement->execute()) {
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception("Error findAll(chapter)");
        }
    }

    /**
     * Get chapter number
     *
     * @param int $id
     * @return void
     */
    public function chapterNumber($id)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select max(number) as number from %s where book = %s",
                $this->model::getInfo()["table"],
                $id
            )
        );

        if ($statement->execute()) {
            $number = $statement->fetch(\PDO::FETCH_ASSOC);
            
            if ($number === null) {
                return 1;
            } else {
                return $number['number'] + 1;
            }
        } else {
            throw new \Exception("Error findAll(chapter)");
        }
    }
}