<?php

namespace Application\Form;

use Application\Model\Comment;
use Framework\FormInterface;
use Framework\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Validator;
use Application\Manager\CommentManager;

/**
 * Class AddForm
 * @package Application\Form\Comment
 */
class CommentForm implements FormInterface
{
    /**
     * @var Comment
     */
    private $comment;

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
    public function __construct(Comment $model)
    {
        $this->comment = $model;
    }

    public function handle(ServerRequestInterface $request): FormInterface
    {
        if ($request->getMethod() === "POST" && isset($request->getParsedBody()["comment"])) {
            $this->submitted = true;

            $commentData = $request->getParsedBody()["comment"];
            
            if (isset($commentData['like']) && $commentData['like'] !== null) {
                $this->comment->setId($commentData['id']);
                $this->comment->setChapter($commentData['chapter']);
                $this->comment->setLike(1);
            }elseif (isset($commentData['report']) && $commentData['report'] !== null) {
                $this->comment->setId($commentData['id']);
                $this->comment->setChapter($commentData['chapter']);
                $this->comment->setReport(1);
            } else {
                $this->comment->setChapter($commentData["chapter"]);
                $this->comment->setOwner($commentData["owner"]);
                $this->comment->setContent($commentData["content"]);
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
        $valid = new Validator($this->comment);
        
        if (!empty($valid->valid())) {
            $this->errors = $valid->valid();
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
        return $this->comment;
    }
}
