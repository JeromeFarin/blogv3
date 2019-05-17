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

    public function user(User $user)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "select * from %s where id = %s",
                $user::getInfo()['table'],
                $user->getId()
            )
        );
        
        if ($statement->execute()) {
            return $statement->fetchAll(\PDO::FETCH_CLASS, 'Application\Model\User');
        } else {
            return false;
        }
    }

    public function code(User $object)
    {
        $statement = $this->getPdo()->prepare(
            sprintf(
                "update %s set code = '%s', codevalidity = '%s' where id = %s",
                $object::getInfo()['table'],
                addslashes($object->getCode()),
                addslashes($object->getCodeValidity()),
                $object->getId()
            )
        );
        
        if ($statement->execute()) {
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}