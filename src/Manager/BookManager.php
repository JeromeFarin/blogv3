<?php
namespace Application\Manager;

use Framework\Manager;
use Application\Model\Book;

/**
 * Class BookManager
 * @package Application\Manager
 */
class BookManager extends Manager
{
    /**
     * Book Model
     *
     * @var Book
     */
    public $model;

    /**
     * Constructor
     */
    public function __construct() {
        $this->model = new Book();
    }

    /**
     * Find all book not empty
     *
     * @return mixed
     */
    public function findAllDone()
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select b.* from %s b inner join chapter c on c.book=b.id where b.hidden = 0 and c.content not like 'null' group by b.id",
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