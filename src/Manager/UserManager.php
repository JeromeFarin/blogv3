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