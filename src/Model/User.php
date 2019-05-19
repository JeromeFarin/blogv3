<?php
namespace Application\Model;

use Application\Manager;
use Framework\ModelInterface;
use Framework\Constraints;

/**
 * Class User
 * @package Application\Model
 */
class User implements ModelInterface
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $mail;

    /**
     * @var string
     */
    public $pass; 

    /**
     * @var string
     */
    public $code; 

    /**
     * @var string
     */
    public $codevalidity;

    /**
     * Get model info
     *
     * @return array
     */
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
                "code" => "code",
                "codevalidity" => "codevalidity"
            ],
            "constraints" => [
                "mail" => [
                    new Constraints\Required('This field must not be empty'),
                    new Constraints\IsMail('This field must be contain an "@"')
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

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of codevalidity
     */ 
    public function getCodeValidity()
    {
        return $this->codevalidity;
    }

    /**
     * Set the value of codevalidity
     *
     * @return  self
     */ 
    public function setCodeValidity($codevalidity)
    {
        $this->codevalidity = $codevalidity;

        return $this;
    }
}