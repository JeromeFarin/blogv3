<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\CommentManager;

class CommentHandler extends Controller
{
    private $manager;

    public function __construct(CommentManager $manager) {
        $this->manager = $manager;
    }

    public function add($comment)
    {
        return $this->manager->insert($comment);
    }

    public function list($param)
    {
        return $this->manager->findAllComment($param);
    }
}
