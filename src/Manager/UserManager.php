<?php
namespace Application\Manager;

use Framework\Manager;
use Application\Model\User;

class UserManager extends Manager
{
    protected $model;

    public function __construct(User $model) {
        $this->model = $model;
    }
    public function check(User $user)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select * from %s where %s = '%s'",
                $user::getInfo()['table'],
                'mail',
                $user->getMail()
            )
        );
        
        if ($statement->execute()) {
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function pass(User $user)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select pass from %s where %s = '%s'",
                $user::getInfo()['table'],
                'id',
                $user->getId()
            )
        );
        
        if ($statement->execute()) {
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}