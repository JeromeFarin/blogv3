<?php
namespace Application\Manager;

use Framework\Manager;

class UserManager extends Manager
{
    protected $model;

    public function __construct(\Application\Model\User $model) {
        $this->model = $model;
    }
    public function check($user)
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
}