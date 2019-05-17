<?php

namespace Application\Form;

use Application\Model\User;
use Framework\FormInterface;
use Framework\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Validator;
use Application\Manager\UserManager;

/**
 * Class AddForm
 * @package Application\Form\Book
 */
class UserForm implements FormInterface
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var bool
     */
    public $submitted = false;

    /**
     * @var array
     */
    public $errors = [];

    private $manager;

    /**
     * AddForm constructor.
     * @param ModelInterface $model
     */
    public function __construct(UserManager $manager)
    {
        $this->user = new User();
        $this->manager = $manager;
    }

    public function handle(ServerRequestInterface $request): FormInterface
    {
        if ($request->getMethod() === "POST" && isset($request->getParsedBody()["user"])) {
            $this->submitted = true;

            $userData = $request->getParsedBody()["user"];
            
            if (isset($userData["id"])) {
                $this->user->setId($userData["id"]);
                $this->user = $this->manager->user($this->user)[0];
                foreach ($userData as $key => $property) {
                    $this->user->{sprintf("set%s", ucfirst($key))}($property);
                }
            } elseif (!isset($userData["pass"])) {
                $this->user->setUsername($userData["username"]);
                $this->user->setMail($userData["mail"]);
            } else {
                $this->user->setPass($userData["pass"]);
                $this->user->setMail($userData["mail"]);
            }
        }
        
        return $this;
    }

    public function isSubmitted(): bool
    {
        return $this->submitted;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {        
        $valid = new Validator($this->user);
        
        if (!empty($valid->valid())) {
            $this->errors += $valid->valid();
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return ModelInterface
     */
    public function getData(): ModelInterface
    {
        return $this->user;
    }
}
