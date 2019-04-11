<?php
namespace Application\Manager;

use Framework\Manager;
use Application\Model\User;

class UserManager extends Manager
{
    public $model;

    public function __construct() {
        $this->model = new User();
    }
    public function checkMail($user)
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
            $resultUser = $statement->fetch(\PDO::FETCH_ASSOC);
            return $resultUser;
        } else {
            return false;
        }
    }

    public function check($request)
    {
        $parameters = [];

        foreach ($request as $key => $value) {
            array_push($parameters, $key . '=\'' . $value . '\'');
        };

        $statement = $this->getPdo()->prepare(
            sprintf(
                "select * from %s where %s",
                $this->model::getInfo()['table'],
                implode(" and ", $parameters)
            )
        );
        
        if ($statement->execute()) {
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}