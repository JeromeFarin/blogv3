<?php

namespace Application\Form;

use Application\Model\Comment;
use Framework\FormInterface;
use Framework\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AddForm
 * @package Application\Form\Comment
 */
class CommentForm extends Form implements FormInterface
{
    /**
     * @var Comment
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
     * AddForm constructor.
     * @param ModelInterface $model
     */
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    /**
     * @param ServerRequestInterface $request
     * @return FormInterface
     */
    public function handle(ServerRequestInterface $request): FormInterface
    {
        if ($request->getMethod() === "POST" && isset($request->getParsedBody()["comment"])) {
            $this->submitted = true;

            $commentData = $request->getParsedBody()["comment"];
            
            $this->getSetter($commentData);      
        }

        return $this;
    }
}
