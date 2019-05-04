<?php
namespace Application\Model;

use Application\Manager;
use Framework\ModelInterface;
use Framework\Constraints;

class Comment implements ModelInterface
{
    public $id;
    public $chapter;
    public $owner;
    public $content;
    public $like;
    public $report;

    public static function getInfo(): array
    {
        return [
            "table" => "comment",
            "manager" => Manager\CommentManager::class,
            "columns" => [
                "id" => "id",
                "chapter" => "chapter",
                "owner" => "owner",
                "content" => "content"
            ],
            "constraints" => [
                "owner" => [
                    new Constraints\Required('This field must not be empty'),
                    new Constraints\MinLenght(2,'This field must contain 2 characters minimum'),
                    new Constraints\MaxLenght(255,'This field must contain 255 characters maximum')
                ],
                "content" => [
                    new Constraints\Required('This field must not be empty'),
                    new Constraints\MinLenght(2,'This field must contain 2 characters minimum')
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
     * Get the value of chapter
     */ 
    public function getChapter()
    {
        return $this->chapter;
    }

    /**
     * Set the value of chapter
     *
     * @return  self
     */ 
    public function setChapter($chapter)
    {
        $this->chapter = $chapter;

        return $this;
    }

    /**
     * Get the value of owner
     */ 
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set the value of owner
     *
     * @return  self
     */ 
    public function setOwner($owner)
    {
        $this->owner = $owner;

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

    /**
     * Get the value of like
     */ 
    public function getLike()
    {
        return $this->like;
    }

    /**
     * Set the value of like
     *
     * @return  self
     */ 
    public function setLike($like)
    {
        $this->like = $like;

        return $this;
    }

    /**
     * Get the value of report
     */ 
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Set the value of report
     *
     * @return  self
     */ 
    public function setReport($report)
    {
        $this->report = $report;

        return $this;
    }
}