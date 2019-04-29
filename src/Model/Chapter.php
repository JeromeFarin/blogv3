<?php
namespace Application\Model;

use Application\Manager;
use Framework\ModelInterface;

class Chapter implements ModelInterface
{
    public $id;
    public $book;
    public $number;
    public $name;
    private $content;

    public static function getInfo(): array
    {
        return [
            "table" => "chapter",
            "manager" => Manager\ChapterManager::class,
            "columns" => [
                "id" => "id",
                "book" => "book",
                "number" => "number",
                "name" => "name",
                "content" => "content"
            ],
            "required" => [
                "number" => [
                    "min-length" => "1",
                    "max-length" => "10"
                ],
                "name" => [
                    "min-length" => "2",
                    "max-length" => "255"
                ]
            ]
        ];
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of book
     */ 
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set the value of book
     *
     * @return  self
     */ 
    public function setBook($book)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get the value of number
     */ 
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set the value of number
     *
     * @return  self
     */ 
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}