<?php

namespace Application\Form\User;

use Application\Model\User;
use Framework\FormInterface;
use Framework\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;
use Application\Handler\UserHandler;

/**
 * Class AddForm
 * @package Application\Form\Book
 */
class AddForm implements FormInterface
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var bool
     */
    private $submitted = false;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * AddForm constructor.
     * @param ModelInterface $model
     */
    public function __construct(ModelInterface $model)
    {
        $this->user = $model;
    }

    public function handle(ServerRequestInterface $request): FormInterface
    {
        if ($request->getMethod() === "POST" && isset($request->getParsedBody()["user"])) {
            $this->submitted = true;

            $userData = $request->getParsedBody()["user"];

            $this->user->setMail($userData["mail"]);
            $this->user->setPass($userData["pass"]);
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
        $handler = new UserHandler();
        if ($this->user->getMail() === null || empty($this->user->getMail()) || $handler->check($this->user) === 'mail') {
            $this->errors["mail"] = "Pas de compte trouvé.";
        }

        if ($this->user->getPass() === null || empty($this->user->getPass()) || $handler->check($this->user) === 'pass') {
            $this->errors["pass"] = "Mot de passe incorrect.";
        }

        return count($this->errors) === 0;
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
