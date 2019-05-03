<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\UserManager;

class UserHandler extends Controller
{
    private $manager;
    public $form;

    public function __construct(UserManager $manager) {
        $this->manager = $manager;
    }

    public function login($form)
    {
        $this->form = $form;

        if (isset($this->form->submitted)) {
            $object = $this->form->getData();
        } else {
            $object = $this->form;
        }

        if ($this->checkMail($object)) {
            return $this;
        }
    }

    public function checkMail($object)
    {
        $check = $this->manager->check($object);
        if (!$check) {
            return $this->form->errors = array('mail' => 'No profiles found');
        } else {
            return $this->checkPass($object,$check);
        }
    }

    private function checkPass($object,$check)
    {
        if (password_verify($object->getPass(),$check['pass'])) {
            $_SESSION['mail'] = $check['mail'];
            $_SESSION['pass'] = $object->getPass();
            return true;
        } else {
            return $this->form->errors = array('pass' => 'Bad password for this profile');
        }
    }

    public function logout()
    {
        return session_destroy();
    }

    public function list()
    {
        return $this->manager->findAll();
    }
}
