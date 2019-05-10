<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\UserManager;
use Application\Model\User;

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

    public function checkMail(User $object)
    {
        $check = $this->manager->check($object);
        if (!$check) {
            return $this->form->errors = array('mail' => 'No profiles found');
        } else {
            return $this->checkPass($object,$check);
        }
    }

    private function checkPass(User $object,$check)
    {
        if (password_verify($object->getPass(),$check['pass'])) {
            $_SESSION['mail'] = $check['mail'];
            $_SESSION['pass'] = $object->getPass();
            return true;
        } else {
            return $this->form->errors = array('pass' => 'Bad password for this profile');
        }
    }

    public function getPass(User $object)
    {
        return $this->manager->pass($object);
    }

    public function logout()
    {
        return session_destroy();
    }

    public function list()
    {
        return $this->manager->findAll();
    }

    public function add(User $object)
    {
        return $this->manager->insert($object);
    }

    public function edit(User $object)
    {        
        return $this->manager->update($object);
    }

    public function delete(User $object)
    {
        return $this->manager->delete($object);
    }

    public function sendResetPass(User $object)
    {
        $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587));
        $transport->setUsername('j.farin38@gmail.com');
        $transport->setPassword('BUbuse38');

        $mailer = new \Swift_Mailer($transport);

        $message = new \Swift_Message('Hello Email');
        $message->setFrom('blog@gmail.com');
        $message->setTo($object->getMail());
        $message->setBody(
            $this->render(
                'user/mail_change_pass.twig',
                [
                    'name' => $object->getUsername(),
                    'title' => 'Change Password'
                ]
            ),
            'text/html'
        );

        $mailer->send($message);
    }
}
