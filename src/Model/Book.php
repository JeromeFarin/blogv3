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
    public $date_finish;

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
                "date_finish" => "date_finish",
            ],
            "type" => [
                "id" => "hidden",
                "name" => "text",
                "owner" => "text",
                "cover" => "file",
                "date_finish" => "date"
            ],
            "placeholder" => [
                "name" => "Book name",
                "owner" => "Book owner"
            ],
            "validation" => [
                "name" => ["required", "min-length-20"],
                "owner" => ["required", "min-length-5"],
            ],
            "required" => [
                "name" => "",
                "owner" => ""
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

    public function setDate_Finish($date_finish)
    {
        $this->date_finish = $date_finish;
    }

    public function getDate_Finish()
    {
        return $this->date_finish;
    }
}
