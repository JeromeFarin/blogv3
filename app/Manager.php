<?php


namespace Framework;

use Application\Model;

/**
 * Class Manager
 * @package Framework
 */
abstract class Manager
{
    /**
     * @var \PDO
     */
    private static $pdo;

    public function getPdo(): \PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new \PDO("mysql:host=srv170.main-hosting.eu;dbname=u194151626_blog", "u194151626_blog", "BUbuse38");
        }

        return self::$pdo;
    }

    public function persist($object)
    {
        if ($object->getId() === null) {
            $this->insert($object);
        } else {
            return $this->update($object);
        }
    }

    public function delete($object)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "delete from %s where id=%s",
                $object::getInfo()["table"],
                $object->getId()
            )
        );

        if ($statement->execute()) {
            return true;
        } else {
            throw new \Exception("Error delete()");
        }
    }

    private function update($object)
    {
        $parameters = [];

        foreach ($object::getInfo()["columns"] as $column => $property) {
            $value = $object->{sprintf("get%s", ucfirst($property))}();
            if ($value === null) {
                $value = 'null';
            }
            $parameters[$column] = $column."='".$value."'";
        }
        
        $statement = $this->getPdo()->prepare(
            sprintf(
                "update %s set %s where %s",
                $object::getInfo()["table"],
                implode(",",$parameters),
                $parameters["id"]
            )
        );
        
        if ($statement->execute(array_values($parameters))) {
            return $object->getId();
        } else {
            throw new \Exception("Error update()");
        }
    }

    public function insert($object)
    {
        $parameters = [];

        foreach ($object::getInfo()["columns"] as $column => $property) {
            $parameters[$column] = $object->{sprintf("get%s", ucfirst($property))}();
        }
        

        $statement = $this->getPdo()->prepare(
            sprintf(
                "insert into %s (%s) values (%s)",
                $object::getInfo()["table"],
                implode(",", array_keys($parameters)),
                implode(",", array_fill(0, count($parameters), "?"))
            )
        );
        if ($statement->execute(array_values($parameters))) {
            return true;
        } else {
            throw new \Exception("Error insert()");
        }
    }

    public function findAll()
    {
        $book = new Model\Book();
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select * from %s",
                $book::getInfo()["table"]
            )
        );

        if ($statement->execute()) {
            return $statement;
        } else {
            throw new \Exception("Error findAll()");
        }
    }

    public function find($book)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select * from %s where id=%s",
                $book::getInfo()["table"],
                $book->getId()
            )
        );

        if ($statement->execute()) {
            return $statement;
        } else {
            throw new \Exception("Error find()");
        }
    }
}
