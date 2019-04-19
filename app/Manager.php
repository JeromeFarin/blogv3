<?php


namespace Framework;

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

    public function getPdo()
    {
        if (self::$pdo === null) {
            self::$pdo = new \PDO(
                getenv("DATABASE_DSN"),
                getenv('DATABASE_USER'),
                getenv('DATABASE_PASSWORD')
            );
        }

        return self::$pdo;
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

    public function update($object)
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
        // dd($parameters);
        $statement = $this->getPdo()->prepare(
            sprintf(
                "insert into %s (%s) values (%s)",
                $object::getInfo()["table"],
                implode(",", array_keys($parameters)),
                implode(",", array_fill(0, count($parameters), "?"))
            )
        );
        
        if ($statement->execute(array_values($parameters))) {
            $object->setId($this->getPdo()->lastInsertId());
            return $object->getId();
        } else {
            throw new \Exception("Error insert()");
        }
    }

    public function findAll()
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select * from %s",
                $this->model::getInfo()["table"]
            )
        );

        if ($statement->execute()) {
            return $statement->fetchAll(\PDO::FETCH_CLASS,$this->namespace);
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
            return $statement->fetch(\PDO::FETCH_OBJ);
        } else {
            throw new \Exception("Error find()");
        }
    }
}
