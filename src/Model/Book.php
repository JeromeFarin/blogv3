<?php
namespace Application\Model;

use Application\Manager;
use Framework\ModelInterface;

class Book implements ModelInterface
{
    public $id;
    public $name;
    public $owner;
    public $cover;
    public $finished_date;

    public static function getInfo(): array
    {
        return [
            "table" => "book",
            "manager" => Manager\BookManager::class,
            "columns" => [
                "id" => "id",
                "name" => "name",
                "owner" => "owner",
                "cover" => "cover",
                "finished_date" => "finished_date",
            ],
            "required" => [
                "name" => [
                    "min-length" => "5",
                    "max-length" => "255"
                ],
                "owner" => [
                    "min-length" => "5",
                    "max-length" => "255"
                ]
            ]
        ];
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    public function getCover()
    {
        return $this->cover;
    }
    
    /**
     * Get the value of finished_date
     */ 
    public function getFinished_date()
    {
        return $this->finished_date;
    }

    /**
     * Set the value of finished_date
     *
     * @return  self
     */ 
    public function setFinished_date($finished_date)
    {
        $this->finished_date = $finished_date;

        return $this;
    }
}
