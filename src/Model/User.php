<?php
namespace Application\Model;

use Application\Manager;
use Framework\ModelInterface;
use Framework\Constraints;

class User implements ModelInterface
{
    public $id;
    public $username;
    public $mail;
    public $pass;  

    public static function getInfo(): array
    {
        return [
            "table" => "user",
            "manager" => Manager\UserManager::class,
            "columns" => [
                "id" => "id",
                "username" => "username",
                "mail" => "mail",
                "pass" => "pass",
            ],
            "constraints" => [
                "mail" => [
                    new Constraints\Required('This field must not be empty')
                ],
                "pass" => [
                    new Constraints\Required('This field must not be empty')
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
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of mail
     */ 
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set the value of mail
     *
     * @return  self
     */ 
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get the value of pass
     */ 
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set the value of pass
     *
     * @return  self
     */ 
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }
}