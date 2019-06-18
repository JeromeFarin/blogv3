<?php
namespace Application\Model;

use Application\Manager;
use Framework\ModelInterface;
use Framework\Constraints;

/**
 * Class Book
 * @package Application\Book
 */
class Book implements ModelInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $owner;

    /**
     * @var string
     */
    private $cover;

    /**
     * @var string
     */
    private $finished_date;

    /**
     * @var bool
     */
    private $hidden = 0;

    /**
     * Get model info
     *
     * @return array
     */
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
                "hidden" => "hidden",
            ],
            "constraints" => [
                "name" => [
                    new Constraints\Required('The title must not be empty'),
                    new Constraints\MinLenght(2,'The title must contain 2 characters minimum'),
                    new Constraints\MaxLenght(255,'The title must contain 255 characters maximum')
                ],
                "owner" => [
                    new Constraints\Required('The owner must not be empty'),
                    new Constraints\MinLenght(2,'The owner must contain 2 characters minimum'),
                    new Constraints\MaxLenght(255,'The owner must contain 255 characters maximum')
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
     * Get the value of cover
     */ 
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set the value of cover
     *
     * @return  self
     */ 
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
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

    /**
     * Get the value of hidden
     */ 
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set the value of finished_date
     *
     * @return  self
     */ 
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }
}
