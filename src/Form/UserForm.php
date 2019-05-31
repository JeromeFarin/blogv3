<?php

namespace Application\Form;

use Application\Model\User;
use Framework\FormInterface;
use Framework\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;
use Application\Manager\UserManager;

/**
 * Class AddForm
 * @package Application\Form\Book
 */
class UserForm extends Form implements FormInterface
{
    /**
     * @var User
     */
    protected $model;

    /**
     * @var bool
     */
    protected $submitted = false;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var UserManager
     */
    protected $manager;

    /**
     * AddForm constructor.
     * @param ModelInterface $model
     */
    public function __construct(UserManager $manager)
    {
        $this->model = new User();
        $this->manager = $manager;
    }

    /**
     * @param ServerRequestInterface $request
     * @return FormInterface
     */
    public function handle(ServerRequestInterface $request): FormInterface
    {
        if ($request->getMethod() === "POST" && isset($request->getParsedBody()["user"])) {
            $this->submitted = true;

            $userData = $request->getParsedBody()["user"];
            
            $this->getSetter($userData);
        }
        
        return $this;
    }
}
