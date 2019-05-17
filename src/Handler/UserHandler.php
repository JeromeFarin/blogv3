<?php
namespace Application\Handler;

use Framework\Controller;
use Application\Manager\UserManager;
use Application\Model\User;
use Application\Form\UserForm;
use Zend\Diactoros\ServerRequest;

class UserHandler extends Controller
{
    private $manager;
    public $form;

    public function __construct(UserManager $manager, UserForm $form) {
        $this->manager = $manager;
        $this->form = $form;
    }

    public function login(ServerRequest $request)
    {
        $this->form->handle($request);

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return $this->checkMail($this->form->getData());
        }
        
        return $this->form;
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
        $transport = (new \Swift_SmtpTransport(getenv("SWIFT_SMTP"), getenv("SWIFT_PORT"), getenv("SWIFT_TYPE")))->setUsername(getenv("SWIFT_USER"))->setPassword(getenv("SWIFT_PASS"));

        $mailer = new \Swift_Mailer($transport);

        $message = new \Swift_Message('Change password of Blog');
        $message->setFrom(array('blog@blog.com' => 'Support'));
        $message->setTo(array($object->getMail() => $object->getMail()));
        $message->setBody(
            $this->render('mail/mail_change_pass.twig', array(
                'title' => 'Change Password',
                'name' => $object->getUsername(),
                'id' => $object->getId(),
                'code' => $this->setCode($object)
            ),true),
            'text/html'
        );
        
        if ($mailer->send($message)) {
            return "An mail was send to ".$object->getMail();
        } else {
            return "An error was up, please contact administrator";
        }
    }

    private function setCode(User $object)
    {
        $code = substr(rand(),0,4);
        $codeValidity = time()+300;

        $object->setCode(password_hash($code,PASSWORD_BCRYPT));
        $object->setCodeValidity(password_hash($codeValidity,PASSWORD_BCRYPT));

        $this->manager->code($object);
        
        return $code;
    }
}
